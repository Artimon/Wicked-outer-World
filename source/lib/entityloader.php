<?php

class EntityLoader extends dataObjectProvider {
	/**
	 * Object types, may be temporary as we discover the need
	 * of more detailed types. All none-player-entities could
	 * have negative values to use the starship ids.
	 *
	 * @const int
	 */
	const TYPE_PLAYER	= 1;
	const TYPE_ITEM		= 2;
	const TYPE_ASTEROID	= 3;

	/**
	 * @var Account
	 */
	private $account;


	/**
	 * @param Account $account
	 */
	public function __construct(Account $account) {
		$this->account = $account;
	}

	/**
	 * @return Account
	 */
	protected function account() {
		return $this->account;
	}

	/**
	 * @return Vector
	 */
	public function randomPosition() {
		// @TODO read out sector data.
		return new Vector(
			rand(300, 600),
			rand(100, 500)
		);
	}

	/**
	 * @return int
	 */
	protected function randomItem() {
		$sector = Sector_Abstract::getInstance(
			$this->account()
		);

		$items = $sector->starTravelItems();
		$percentage = rand(1, 100);

		foreach ($items as $techId => $chance) {
			if ($percentage <= $chance) {
				return $techId;
			}
		}

		return 0;
	}

	/**
	 * @param int $duration
	 */
	public function initSector($duration) {
		$database = $this->database();

		$accountId = $this->account()->id();
		$timeout = TIME + (int)$duration;

		$sql = "
			DELETE FROM `entities`
			WHERE
				`accountId` = {$accountId};";
		$database->query($sql)->freeResult();

		$position = $this->randomPosition();
		$items = array(
			array(
				self::TYPE_PLAYER,
				0,
				$accountId,
				$position->x,
				$position->y,
				$timeout,
				$position->x,
				$position->y
			)
		);

		for ($i = 5; $i > 0; --$i) {
			$position = $this->randomPosition();
			$items[] = array(
				self::TYPE_ITEM,
				$this->randomItem(),
				$accountId,
				$position->x,
				$position->y,
				$timeout,
				$position->x,
				$position->y
			);
		}

		$values = array();
		foreach ($items as $item) {
			$values[] = '(' . implode(',', $item) . ')';
		}
		$values = implode(',', $values);

		$sql = "
			INSERT INTO `entities`
			(
				`type`,
				`techId`,
				`accountId`,
				`positionX`,
				`positionY`,
				`timeout`,
				`targetX`,
				`targetY`
			)
			VALUES
				{$values};";
		$database->query($sql)->freeResult();
	}

	/**
	 * @param int $type
	 * @param int $accountId
	 * @return bool
	 */
	protected function isPlayer($type, $accountId) {
		return (
			$type === self::TYPE_PLAYER &&
			$accountId === $this->account()->id()
		);
	}

	/**
	 * @param Vector $position
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	protected function notInRange(Vector $position, $x, $y) {
		return (
			(abs($position->x - $x) > 250) ||
			(abs($position->y - $y) > 250)
		);
	}

	/**
	 * @param int $type
	 * @param int $techId
	 * @param int $accountId
	 * @return string
	 */
	protected function name($type, $techId, $accountId) {
		switch ($type) {
			case self::TYPE_PLAYER:
				return ObjectPool::getLegacy('account', $accountId)->name();

			case self::TYPE_ITEM:
				return Technology::raw($techId)->name();

			default:
				return '';
		}
	}

	/**
	 * @param Vector $player
	 * @param Vector $entity
	 * @return bool true on update
	 */
	protected function vectorUpdate(Vector $player, Vector $entity) {
		// No position yet given.
		if ($player->length() == 0) {
			$player->set($entity);
		}

		// Do not use identity, it must only check values.
		if ($player != $entity) {
			$entity->set($player);

			return true;
		}

		return false;
	}

	/**
	 * @param int $entityId
	 */
	protected function storeItem($entityId) {
		$entityId = (int)$entityId;

		$account = $this->account();
		$accountId = $account->id();

		$sql = "
			SELECT
				`techId`
			FROM
				`entities`
			WHERE
				`id` = :id AND
				`accountId` = :accountId AND
				`type` = :type
			LIMIT 1;";

		$database = new Lisbeth_Database();

		$statement = $database->newStatement();
		$statement->prepare(
			array(
				'id' => $entityId,
				'accountId' => $accountId,
				'type' => self::TYPE_ITEM
			),
			$sql
		);

		$techId = $statement->execute()->fetchOne();
		$database->freeResult();

		if ($techId) {
			$account->stockage()->appear($techId);
		}
	}

	protected function newItem($entityId) {
		$entityId = (int)$entityId;

		$database = $this->database();

		$sql = "
			DELETE FROM `entities`
			WHERE
				`id` = {$entityId} AND
				`type` = ".self::TYPE_ITEM;
		$database
			->query($sql)
			->freeResult();

//		$position = $this->randomPosition();
//
//		$sql = "
//			INSERT INTO
//				`entities`
//			SET
//				`type` = ".self::TYPE_ITEM.",
//				`accountId` = {$this->account()->id()},
//				`positionX` = {$position->x},
//				`positionY` = {$position->y};";
//		$database
//			->query($sql)
//			->freeResult();
	}

	/**
	 * @param int $entityId
	 * @return bool
	 */
	protected function canCollect($entityId) {
		$entityId = (int)$entityId;

		$timeout = TIME;
		$sql = "
			SELECT
				COUNT(*) AS `valid`
			FROM
				`entities`
			WHERE
				`id` = {$entityId} AND
				`accountId` = {$this->account()->id()} AND
				`timeout` >= {$timeout};";

		$database = $this->database();
		$result = $database->query($sql)->fetchOne();
		$database->freeResult();

		return ($result > 0);
	}

	/**
	 * @param int $entityId
	 * @param int $entityType
	 * @param float $distance
	 * @return null|string
	 */
	protected function command($entityId, $entityType, $distance) {
		switch ($entityType) {
			case self::TYPE_PLAYER:
				return null;

			case self::TYPE_ITEM:
				if ($distance < 25 && $this->canCollect($entityId)) {
					$this->storeItem($entityId);
					$this->newItem($entityId);
					return 'fade';
				}

				return null;

			case self::TYPE_ASTEROID:
				return null;
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function entitiesJson() {
		$request = Leviathan_Request::getInstance();

		// Current position.
		$playerPos = new Vector(
			$request->get('myX', .0),
			$request->get('myY', .0)
		);

		// Move destination, not necessarily equal to target position.
		$playerDest = new Vector(
			$request->get('toX', .0),
			$request->get('toY', .0)
		);

		$targetId = (int)$request->get('target', 0);

		// @TODO read out sector id.
		$forceTypes = array(self::TYPE_ITEM, self::TYPE_ASTEROID);
		$forceTypes = implode(',', $forceTypes);

		$playerType = self::TYPE_PLAYER;

//		$sql = "
//			SELECT *
//			FROM
//				`entities`
//			WHERE
//				`type` IN({$forceTypes}) AND
//				`accountId` = {$this->account()->id()}
//			UNION SELECT *
//			FROM
//				`entities`
//			WHERE
//				`type` = {$playerType}
//			LIMIT 10;";

		$sql = "
			SELECT *
			FROM
				`entities`
			WHERE
				`accountId` = {$this->account()->id()}
			LIMIT 10;";
		$database = $this->database();
		$database->query($sql);

		$updatePosition = false;
		$entities = array();
		while ($temp = $database->fetch()) {
			$id			= (int)$temp['id'];
			$type		= (int)$temp['type'];
			$techId		= (int)$temp['techId'];
			$accountId	= (int)$temp['accountId'];
			$isPlayer	= $this->isPlayer($type, $accountId);

			$entityPos = new Vector($temp['positionX'], $temp['positionY']);
			$entityDest = new Vector($temp['targetX'], $temp['targetY']);

			$command = null;
			if ($isPlayer) {
				$updatePosition =
					$this->vectorUpdate($playerPos, $entityPos) ||
					$this->vectorUpdate($playerDest, $entityDest);
			}
			elseif ($id === $targetId) {
				$distance = new Vector();
				$distance->diff($playerPos, $entityPos);
				$command = $this->command($id, $type, $distance->length());
			}

			$entities[] = array(
				'handleObject'	=> $id,
				'type'			=> $type,
				'name'			=> $this->name($type, $techId, $accountId),
				'isPlayer'		=> $isPlayer,
				'positionX'		=> $entityPos->x,
				'positionY'		=> $entityPos->y,
				'targetX'		=> $entityDest->x,
				'targetY'		=> $entityDest->y,
				'command'		=> $command
			);
		}
		$database->freeResult();

		foreach ($entities as $index => &$entity) {
			if ($entity['isPlayer']) {
				continue;
			}

			if (
				$this->notInRange($playerPos, $entity['positionX'], $entity['positionY']) &&
				$this->notInRange($playerPos, $entity['targetX'], $entity['targetY'])
			) {
				unset($entities[$index]);
			}
		}

		if ($updatePosition) {
			$sql = "
				UPDATE `entities`
				SET
					`positionX` = {$playerPos->x},
					`positionY` = {$playerPos->y},
					`targetX` = {$playerDest->x},
					`targetY` = {$playerDest->y}
				WHERE
					`accountId` = {$this->account()->id()} AND
					`type` = ".self::TYPE_PLAYER."
				LIMIT 1;";
			$database->query($sql)->freeResult();
		}

		return json_encode($entities);
	}
}