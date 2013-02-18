<?php

class entityLoader extends dataObjectProvider {
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
	 * @param int $sectorId
	 */
	public function initSector($sectorId) {
		$sectorId = (int)$sectorId;

		$database = $this->database();
// remove/recreate all items on sector enter
		$sql = "UPDATE `entities` SET `commandCreated` = ".TIME.";";
		$database->query($sql)->freeResult();
		return;

		$sql = "
			DELETE FROM `entities`
			WHERE
				`sectorId` = {$sectorId} AND
				`accountId` = {$this->account()->id()};";

		// @TODO Create entities depending on sector settings.
		$sql = "
			INSERT INTO `entities`
			(
				`type`,
				`sectorId`,
				`accountId`,
				`positionX`,
				`positionY`,
				`commandCreated`,
				`targetX`,
				`targetY`
			)
			VALUES
			(1, 0, 1, 350, 450, ".TIME.", 350, 450),
			(1, 0, 2, 400, 400, ".TIME.", 400, 400),
			(2, 0, 1, 450, 100, ".TIME.", 150, 1000),
			(2, 0, 1, 350, 100, ".TIME.", 50, 1000);";
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
	 * @param vector $position
	 * @param int $x
	 * @param int $y
	 * @return bool
	 */
	protected function notInRange(vector $position, $x, $y) {
		return (
			(abs($position->x - $x) > 250) ||
			(abs($position->y - $y) > 250)
		);
	}

	/**
	 * @param int $type
	 * @param int $accountId
	 * @return string
	 */
	protected function name($type, $accountId) {
		switch ($type) {
			case self::TYPE_PLAYER:
				return ObjectPool::getLegacy('account', $accountId)->name();

			case self::TYPE_ITEM:
				return 'something';

			default:
				return '';
		}
	}

	/**
	 * @param vector $player
	 * @param vector $entity
	 * @return bool true on update
	 */
	protected function vectorUpdate(vector $player, vector $entity) {
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
		$items = array(
			CRYSTALS_ID => true,
			ELECTRONICS_ID => true,
			ENERGY_CELLS_ID => true,
			SPACE_JUNK_ID => true
		);

		$entityId = array_rand($items);

		$this->account()->stockage()->appear($entityId);
	}

	protected function newItem($entityId) {
		$entityId = (int)$entityId;

		// @TODO read out sector data.
		$x = rand(300, 600);
		$y = rand(100, 500);

		$database = $this->database();

		$sql = "
			DELETE FROM `entities`
			WHERE
				`id` = {$entityId} AND
				`type` = ".self::TYPE_ITEM;
		$database
			->query($sql)
			->freeResult();

		$sql = "
			INSERT INTO
				`entities`
			SET
				`type` = ".self::TYPE_ITEM.",
				`accountId` = {$this->account()->id()},
				`positionX` = {$x},
				`positionY` = {$y};";
		$database
			->query($sql)
			->freeResult();
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
				if ($distance < 25) {
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
		$request = Request::getInstance();

		// Current position.
		$playerPos = new vector(
			$request->get('myX', .0),
			$request->get('myY', .0)
		);

		// Move destination, not necessarily equal to target position.
		$playerDest = new vector(
			$request->get('toX', .0),
			$request->get('toY', .0)
		);

		$targetId = (int)$request->get('target', 0);

		// @TODO read out sector id.
		$forceTypes = array(self::TYPE_ITEM, self::TYPE_ASTEROID);
		$forceTypes = implode(',', $forceTypes);
		$sql = "
			SELECT *
			FROM
				`entities`
			WHERE
				(
					`type` IN({$forceTypes}) AND
					`accountId` = {$this->account()->id()}
				) OR (
					`sectorId` = 0 AND
					`commandCreated` > ".(TIME - 1800)."
				);";
		$database = $this->database();
		$database->query($sql);

		$updatePosition = false;
		$entities = array();
		while ($temp = $database->fetch()) {
			$id			= (int)$temp['id'];
			$type		= (int)$temp['type'];
			$accountId	= (int)$temp['accountId'];
			$isPlayer	= $this->isPlayer($type, $accountId);

			$entityPos = new vector($temp['positionX'], $temp['positionY']);
			$entityDest = new vector($temp['targetX'], $temp['targetY']);

			$command = null;
			if ($isPlayer) {
				$updatePosition =
					$this->vectorUpdate($playerPos, $entityPos) ||
					$this->vectorUpdate($playerDest, $entityDest);
			} elseif ($id === $targetId) {
				$distance = new vector();
				$distance->diff($playerPos, $entityPos);
				$command = $this->command($id, $type, $distance->length());
			}

			$entities[] = array(
				'handleObject'	=> $id,
				'type'			=> $type,
				'name'			=> $this->name($type, $accountId),
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