<?php

/**
 * Handles containment of item groups.
 */
class techGroup extends techContainerSubclass {
	/**
	 * @var string
	 */
	private $type;

	/**
	 * Set to true if loaded from data, otherwise no update will be performed.
	 *
	 * @var bool
	 */
	private $update = false;

	/**
	 * @var Technology[]
	 */
	private $items = array();

	/**
	 * @param	int		$techId
	 * @return	Technology
	 * @throws	InvalidArgumentException
	 */
	public function item($techId) {
		if ($this->hasItem($techId)) {
			return $this->items[$techId];
		}

		$message = "Tech id '{$techId}' not available in tech group '{$this->type()}'.";
		throw new InvalidArgumentException($message);
	}

	/**
	 * @param int $techId
	 * @return bool
	 */
	public function hasItem($techId) {
		return isset($this->items[$techId]);
	}

	/**
	 * @return Technology[]
	 */
	public function items() {
		$items = $this->items;
		usort($items, function(Technology $a, Technology $b) {
			return $a->name() > $b->name() ? 1 : -1;
		});

		return $items;
	}

	/**
	 * @param	int		$techId
	 * @param	int		$amount
	 * @return	Technology
	 */
	public function newItem($techId, $amount) {
		$techId = (int)$techId;

		$item = new Technology(
			$this->techContainer()->account(),
			$techId,
			$amount
		);

		return $this->addItem($item);
	}

	/**
	 * @param Technology $item
	 * @return Technology
	 */
	public function addItem(Technology $item) {
		$techId = $item->id();
		$this->items[$techId] = $item;

		return $item;
	}

	/**
	 * @param Technology $item
	 * @return Technology
	 */
	public function removeItem(Technology $item) {
		$techId = $item->id();
		unset($this->items[$techId]);

		return $item;
	}

	/**
	 * @return bool
	 */
	public function isEmpty() {
		return empty($this->items);
	}

	/**
	 * @param Technology $item
	 * @param int $amount
	 * @return bool
	 */
	public function canLoadWeight(Technology $item, $amount) {
		$techId = $item->id();

		if ($this->hasItem($techId)) {
			$currentItem = $this->item($techId);
			$weight =
				$currentItem->totalWeight($amount) -
				$currentItem->totalWeight();
		}
		else {
			$weight = $item->totalWeight(
				$amount - $item->amount()
			);
		}

		$techContainer = $this->techContainer();

		$payload = $techContainer->payload() + $weight;
		$availableTonnage = $techContainer->availableTonnage($payload);

		// Can load is valid on greater or equal zero.
		return ($availableTonnage >= 0);
	}

	/**
	 * @param Technology $item
	 * @return int
	 */
	public function loadableAmount(Technology $item) {
		$techId = $item->id();

		$availableTonnage = $this->techContainer()->availableTonnage();
		$amount = (int)($availableTonnage / $item->weight());
		$amount *= $item->stackSize();

		if ($this->hasItem($techId)) {
			$amount += $item->stackGap();
		}

		return $amount;
	}

	/**
	 * @param techGroup $techGroup
	 * @param Technology $item
	 * @param int $amount
	 * @return int amount
	 */
	public function moveItemTo(
		techGroup $techGroup,
		Technology $item,
		$amount = 1
	) {
		if (($amount <= 0) || ($item->amount() < $amount)) {
			return 0;
		}

		if (!$techGroup->canLoadWeight($item, $amount)) {
			return 0;
		}

		if (!$techGroup->hasSlotsAvailable()) {
			return 0;
		}

		if ($techGroup->hasItem($item->id())) {
			$techGroup->item($item->id())->add($amount);
		}
		else {
			$techGroup->newItem($item->id(), $amount);
		}

		$item->sub($amount);
		if ($item->amount() <= 0) {
			$this->removeItem($item);
		}


		$this->update();
		$techGroup->update();

		return $amount;
	}

	/**
	 * @return int
	 */
	public function slotsAvailable() {
		$slots = $this->techContainer()->slots($this->type);

		return ($slots - $this->slotUsage());
	}

	/**
	 * @return int
	 */
	public function slotUsage() {
		$slotUsage = 0;

		foreach ($this->items() as $technology) {
			$slotUsage += $technology->slotUsage();
		}

		return $slotUsage;
	}

	/**
	 * @return bool
	 */
	public function hasSlotsAvailable() {
		return ($this->slotsAvailable() > 0);
	}

	/**
	 * @param int $techId
	 * @return bool
	 */
	public function hasIngredients($techId) {
		$technology = Technology::raw($techId);

		$ingredients = $technology->craftIngredients();
		foreach ($ingredients as $techId => $amount) {
			if (!$this->hasItem($techId)) {
				return false;
			}

			if ($this->item($techId)->amount() < $amount) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Return summed up weight of all items in this tech group.
	 *
	 * @return int
	 */
	public function payload() {
		$payload = 0;

		foreach ($this->items() as $technology) {
			$payload += $technology->totalWeight();
		}

		return $payload;
	}

	/**
	 * @return int Summed up weight of all drives.
	 */
	public function thrust() {
		$thrust = 0;

		foreach ($this->items() as $technology) {
			$thrust += $technology->thrust();
		}

		return $thrust;
	}

	/**
	 * Return summed up damage per round of all weapons.
	 *
	 * @return int
	 */
	public function damagePerRound() {
		$damagePerRound = 0;

		foreach ($this->items() as $technology) {
			$damagePerRound += $technology->damagePerRound();
		}

		return $damagePerRound;
	}

	/**
	 * Return summed up drain per round of all weapons.
	 *
	 * @return int
	 */
	public function drainPerRound() {
		$drainPerRound = 0;

		foreach ($this->items() as $technology) {
			$drainPerRound += $technology->drainPerRound();
		}

		return $drainPerRound;
	}

	/**
	 * Return summed up capacity of all capacity containing items.
	 *
	 * @return int
	 */
	public function capacity() {
		$capacity = 0;

		foreach ($this->items() as $technology) {
			$capacity += $technology->totalCapacity();
		}

		return $capacity;
	}

	/**
	 * Return summed up armor of all armor giving items.
	 *
	 * @return int
	 */
	public function plating() {
		$armor = 0;

		foreach ($this->items() as $technology) {
			$armor += $technology->totalArmor();
		}

		return $armor;
	}

	/**
	 * Return summed up recharge per round of all weapons.
	 *
	 * @return int
	 */
	public function rechargePerRound() {
		$rechargePerRound = 0;

		foreach ($this->items() as $technology) {
			$rechargePerRound += $technology->rechargePerRound();
		}

		return $rechargePerRound;
	}

	/**
	 * Return the highest value of the equipped drives.
	 *
	 * @return int
	 */
	public function starTourSeconds() {
		$seconds = 0;

		foreach ($this->items() as $technology) {
			$seconds += $technology->starTourSeconds();
		}

		return $seconds;
	}

	/**
	 * @param	bool		$type
	 * @return	techGroup
	 */
	public function setType($type) {
		$this->type = $type;

		return $this;
	}

	/**
	 * @return string
	 */
	public function type() {
		return $this->type;
	}

	/**
	 * @return bool
	 */
	public function update() {
		if ($this->update === false) {
			return false;
		}

		$account = $this->techContainer()->account();

		$field = techSelector::fieldFromType($this->type());
		$items = $this->toJson();
		$account
			->setValue($field, $items)
			->update();

		return true;
	}

	/**
	 * @param	string		$json
	 * @return	techGroup
	 */
	public function fromJson($json) {
		$data = json_decode($json, true);

		$this->items = array();
		$this->update = true;

		if (!is_array($data)) {
			return $this;
		}

		$items = array();
		foreach ($data as $techId => $amount) {
			$items[$techId] = $this->newItem($techId, $amount);
		}

		return $this;
	}

	/**
	 * @return string
	 */
	public function toJson() {
		$data = array();

		foreach ($this->items as $techId => $item) {
			$amount = $item->amount();
			if ($amount > 0) {
				$data[$techId] = $amount;
			}
		}

		return json_encode($data);
	}
}
