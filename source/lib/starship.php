<?php

/**
 * Handles starships.
 * Starships and accounts are the same.
 */
class Starship extends TechContainerAbstract {
	/**
	 * @var Condition
	 */
	private $condition;

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
	 * @return float
	 */
	public function repair() {
		return $this->account()->repair();
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
		return $this->account()->incrementRepair($value);
	}
}