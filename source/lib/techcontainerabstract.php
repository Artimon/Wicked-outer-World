<?php

/**
 * Things like starships or stockage are tech containers.
 * The tech container provides tech selector access.
 */
abstract class techContainerAbstract
	extends technology
	implements techContainerInterface {

	/**
	 * @var techSelector
	 */
	private $techSelector;

	/**
	 * @return techSelector
	 */
	public function techSelector() {
		if (null === $this->techSelector) {
			$this->techSelector = new techSelector($this);
		}

		return $this->techSelector;
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	public function hasGroup($type) {
		try {
			$this->groupByName($type);
			return true;
		}
		catch (InvalidArgumentException $e) {
			return false;
		}
	}

	/**
	 * @param string $type
	 * @return techGroup
	 */
	public function groupByName($type) {
		return $this->techSelector()->byName($type);
	}

	/**
	 * @return bool true if free tonnage available
	 */
	public function hasAvailableTonnage() {
		// Available only if greater than zero.
		return ($this->availableTonnage() > 0);
	}

	/**
	 * @TODO Will most likely become float.
	 *
	 * @param int $probePayload
	 * @return int
	 */
	public function availableTonnage($probePayload = null) {
		if (is_null($probePayload)) {
			$probePayload = $this->payload();
		}

		return ($this->tonnage() - $probePayload);
	}

	/**
	 * @param technology $item
	 * @return int
	 */
	public function loadableAmount(technology $item) {
		$techId = $item->id();
		$group = $this->groupByItem($item);

		if ($group->hasItem($techId)) {
			$groupItem = $group->item($techId);
		}
		else {
			$groupItem = technology::raw($techId);
		}

		return min(
			$item->amount(),
			$group->loadableAmount($groupItem)
		);
	}

	/**
	 * @param technology $item
	 * @return techGroup
	 */
	public function itemSlot(technology $item) {
		return $this->groupByName(
			$item->starshipSlot()
		);
	}
}