<?php

/**
 * Handles item stockage.
 */
class stockage extends techContainerAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('stock');
	}

	/**
	 * @return techGroup
	 */
	public function stock() {
		return $this->techSelector()->stock();
	}

	/**
	 * @return techGroup
	 */
	public function fiddle() {
		return $this->techSelector()->fiddle();
	}

	/**
	 * Make a new item appear from the void.
	 *
	 * @param int $techId
	 * @param int $amount
	 * @return int items appeared
	 */
	public function appear($techId, $amount = 1) {
		$item = new Technology(
			$this->account(),
			$techId,
			$amount
		);

		return $this->techSelector()->appear()->moveItemTo(
			$this->stock(),
			$item,
			$amount
		);
	}

	/**
	 * @param Technology $item
	 * @return techGroup
	 */
	public function groupByItem(Technology $item) {
		return $this->techSelector()->stock();
	}

	/**
	 * @param	string	$slotName
	 * @return	int
	 */
	public function slots($slotName) {
		return ($this->groupByName($slotName)->slotUsage() + 1);
	}

	/**
	 * Stockage has no own weight.
	 *
	 * @return int
	 */
	public function weight() {
		return $this->payload();
	}

	/**
	 * Return summed up weight of all stocked items.
	 *
	 * @return int
	 */
	public function payload() {
		return $this->stock()->payload();
	}

	/**
	 * @TODO add formula
	 *
	 * @return int
	 */
	public function tonnage() {
		return 30;
	}
}