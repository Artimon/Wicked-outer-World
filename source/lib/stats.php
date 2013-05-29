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
		return (int)$this->account()->value('inflictedDamage');
	}

	/**
	 * @return int
	 */
	public function takenDamage() {
		return (int)$this->account()->value('takenDamage');
	}

	/**
	 * @return int
	 */
	public function hits() {
		return (int)$this->account()->value('hits');
	}

	/**
	 * @return int
	 */
	public function misses() {
		return (int)$this->account()->value('misses');
	}

	/**
	 * @return int
	 */
	public function currentInflictedDamage() {
		return $this->inflictedDamage;
	}

	/**
	 * @param int $damage
	 * @return Stats
	 */
	public function addInflictedDamage($damage) {
		$damage = (int)$damage;

		$this->inflictedDamage += $damage;
		$this->account()->increment('inflictedDamage', $damage);

		return $this;
	}

	/**
	 * @param int $damage
	 * @return Stats
	 */
	public function addTakenDamage($damage) {
		$this->account()->increment('takenDamage', (int)$damage);

		return $this;
	}

	/**
	 * @param int $amount
	 * @return Stats
	 */
	public function addHits($amount) {
		$this->account()->increment('hits', (int)$amount);

		return $this;
	}

	/**
	 * @param int $amount
	 * @return Stats
	 */
	public function addMisses($amount) {
		$this->account()->increment('misses', (int)$amount);

		return $this;
	}
}