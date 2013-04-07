<?php

class Price extends AccountSubclass {
	/**
	 * @var int
	 */
	private $value = 0;

	/**
	 * @param int $value
	 * @return Price
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
		return $this->account()->decrement('money', $this->value);
	}

	/**
	 * Note:
	 * Does not update immediately.
	 *
	 * @return Account
	 */
	public function sell() {
		return $this->account()->increment('money', $this->value);
	}

	/**
	 * @return bool
	 */
	public function canAfford() {
		$value = $this->account()->money()->value();

		return ($value >= $this->value);
	}
}
