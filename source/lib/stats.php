<?php

/**
 * Handles account stats increase and retrieval.
 */
class Stats extends AccountSubclass {
	/**
	 * @var int
	 */
	private $inflictedDamage = 0;

	/**
	 * @return int
	 */
	public function inflictedDamage() {
		return (
			$this->inflictedDamage +
			$this->account()->value('inflictedDamage')
		);
	}

	/**
	 * @return int
	 */
	public function currentInflictedDamage() {
		return $this->inflictedDamage;
	}

	/**
	 * @param int $damage
	 */
	public function addInflictedDamage($damage) {
		$this->inflictedDamage += (int)$damage;
	}

	public function updateInflictedDamage() {
		$this->account()->setValue(
			'inflictedDamage',
			($this->inflictedDamage + $this->inflictedDamage())
		);
	}
}
