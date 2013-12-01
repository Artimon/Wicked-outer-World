<?php

/**
 * Handles starships.
 * Starships and accounts are the same.
 */
class Starship extends TechContainerAbstract {
	const ENERGY_TO_WEAPONS = 0;
	const ENERGY_TO_SHIELDS = 1;

	/**
	 * @var Condition
	 */
	private $condition;

	/**
	 * @var StarshipData
	 */
	private $data;

	/**
	 * Does not matter when creating several starship objects since they
	 * all use the same data entity.
	 *
	 * @param Account $owner
	 * @param int $starshipId if omitted current starship is selected.
	 * @return Starship
	 */
	public static function create(Account $owner, $starshipId = null) {
		if (!$starshipId) {
			$starshipId = $owner->get('starshipId');
		}

		$starshipData = Lisbeth_ObjectPool::get(
			'StarshipData',
			$starshipId
		);

		$starship = new Starship($owner, $starshipData->get('techId'), 1);
		$starship->setData($starshipData);

		return $starship;
	}

	/**
	 * @param Account $creator
	 * @param int $techId
	 */
	public static function createEntity(Account $creator, $techId) {
		$techId = (int)$techId;
		$lastUpdate = TIME;

		$database = new Lisbeth_Database();
		$database->query("
			INSERT INTO `starships`
			SET
				`ownerId` = {$creator->id()},
				`techId` = {$techId},
				`lastUpdate` = {$lastUpdate};");

		$starshipId = $database->insertId();var_dump($starshipId);
		$creator->starships()->addEntity($starshipId);
	}

	/**
	 * @param StarshipData $data
	 */
	public function setData(StarshipData $data) {
		$this->data = $data;
	}

	/**
	 * @return StarshipData
	 */
	public function data() {
		return $this->data;
	}

	/**
	 * @return Lisbeth_Entity|StarshipData
	 */
	public function dataSource() {
		return $this->data();
	}

	/**
	 * @return bool
	 */
	public function isSelected() {
		return (
			$this->account()->get('starshipId') ==
			$this->data()->id()
		);
	}

	/**
	 * @return techGroup
	 */
	public function weaponry() {
		return $this->techSelector()->weaponry();
	}

	/**
	 * @return techGroup
	 */
	public function ammunition() {
		return $this->techSelector()->ammunition();
	}

	/**
	 * @return techGroup
	 */
	public function equipment() {
		return $this->techSelector()->equipment();
	}

	/**
	 * @return techGroup
	 */
	public function cargo() {
		return $this->techSelector()->cargo();
	}

	/**
	 * @return techGroup
	 */
	public function engine() {
		return $this->techSelector()->engine();
	}

	/**
	 * Return summed up weight of all build in items.
	 *
	 * @return int
	 */
	public function payload() {
		return
			$this->weaponry()->payload() +
			$this->ammunition()->payload() +
			$this->equipment()->payload() +
			$this->cargo()->payload() +
			$this->engine()->payload();
	}

	/**
	 * @param Technology $item
	 * @return int
	 */
	public function loadableAmount(Technology $item) {
		if ($item->level() > $this->account()->level()) {
			return 0;
		}

		return parent::loadableAmount($item);
	}

	/**
	 * @return int
	 */
	public function lastUpdate() {
		return (int)$this->data()->get('lastUpdate');
	}

	/**
	 * One tick every 5 minutes.
	 *
	 * @return int ticks since last update
	 */
	public function passedTicks() {
		$seconds = 300;

		$lastUpdate = (int)($this->lastUpdate() / $seconds);
		$now = (int)(TIME / $seconds);

		return ($now - $lastUpdate);
	}

	/**
	 * @return float
	 */
	public function repair() {
		$repair = (float)$this->data()->get('repair');
		$repair = max(0, $repair);
		$repair += 15 * $this->passedTicks();

		return min(100, $repair);
	}

	/**
	 * @param float $value
	 */
	public function incrementRepair($value) {
		$repair = $this->repair() + $value;

		$this->data()
			->set('repair', $repair)
			->set('lastUpdate', TIME);
	}

	/**
	 * @return bool
	 */
	public function isEnergyToShields() {
		return ($this->data()->get('energySetup') == self::ENERGY_TO_SHIELDS);
	}

	/**
	 * Return current starship weight.
	 *
	 * @return int
	 */
	public function weight() {
		return ($this->maxWeight() - $this->tonnage() + $this->payload());
	}

	/**
	 * Return maximum starship weight.
	 *
	 * @return int
	 */
	public function maxWeight() {
		return parent::weight();
	}

	/**
	 * @param Technology $item
	 * @throws InvalidArgumentException
	 * @return techGroup
	 */
	public function groupByItem(Technology $item) {
		try {
			$slot = $item->starshipSlot();
			return $this->groupByName($slot);
		}
		catch (InvalidArgumentException $e) {
			$message = "Group for item '{$item->name()}' ({$item->id()}) not found.";
			throw new InvalidArgumentException($message);
		}
	}

	/**
	 * @return int
	 */
	public function damagePerRound() {
		return $this->weaponry()->damagePerRound();
	}

	/**
	 * @return int
	 */
	public function drainPerRound() {
		return $this->weaponry()->drainPerRound();
	}

	/**
	 * @return int
	 */
	public function rechargePerRound() {
		return $this->engine()->rechargePerRound();
	}

	/**
	 * @return int
	 */
	public function capacity() {
		return
			$this->equipment()->capacity() +
			$this->engine()->capacity();
	}

	/**
	 * @return int Total starship thrust, overrides Technology::thrust().
	 */
	public function thrust() {
		return $this->engine()->thrust();
	}

	/**
	 * @return float
	 */
	public function movability() {
		$weight = $this->weight();
		$thrust = $this->thrust();
		$movability = 0;
		if ($thrust > 0) {
			$movability = 100 - ($weight / $thrust);
		}

		return (float)$movability;
	}

	/**
	 * @return int
	 */
	public function armor() {
		return $this->equipment()->plating();
	}

	/**
	 * @return null|Technology
	 */
	public function shield() {
		$items = $this->equipment()->items();

		/* @var Technology $technology */
		foreach ($items as $technology) {
			if ($technology->isShield()) {
				return $technology;
			}
		}

		return null;
	}

	/**
	 * @return bool
	 */
	public function hasShield() {
		return (null !== $this->shield());
	}

	/**
	 * @return Condition
	 */
	public function condition() {
		if ($this->condition === null) {
			$this->condition = new Condition($this);
			$this->condition->init();
		}

		return $this->condition;
	}

	/**
	 * @param float $value to subtract from repair percentage.
	 * @return Starship
	 */
	public function addDamage($value) {
		return $this->incrementRepair($value);
	}
}