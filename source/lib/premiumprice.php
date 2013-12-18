<?php

class PremiumPrice extends AccountSubclass {
	/**
	 * @var int
	 */
	private $value = 0;

	/**
	 * @param int $value
	 * @return PremiumPrice
	 */
	public function set($value) {
		$this->value = max(0, (int)$value);

		return $this;
	}

	/**
	 * Note:
	 * Does not update immediately.
	 *
	 * @return Account
	 */
	public function buy() {
		return $this->account()->decrement('premiumCoins', $this->value);
	}

	/**
	 * Note:
	 * Does not update immediately.
	 *
	 * @return Account
	 */
	public function sell() {
		return $this->account()->increment('premiumCoins', $this->value);
	}

	/**
	 * @return bool
	 */
	public function canAfford() {
		$value = $this->account()->myMoney()->premiumCoins();

		return ($value >= $this->value);
	}
}
