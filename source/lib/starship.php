<?php

/**
 * Handles starships.
 * Starships and accounts are the same.
 */
class Starship extends techContainerAbstract {
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
	 * @param technology $item
	 * @throws InvalidArgumentException
	 * @return techGroup
	 */
	public function groupByItem(technology $item) {
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
	 * @return int
	 */
	public function armor() {
		return $this->equipment()->plating();
	}

	/**
	 * @return null|technology
	 */
	public function shield() {
		$items = $this->equipment()->items();

		/* @var technology $technology */
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
}