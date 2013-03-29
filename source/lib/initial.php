<?php

class Initial {
	private $condition;
	private $money;

	/**
	 * @return Initial
	 */
	public static function get() {
		return Lisbeth_ObjectPool::get('Initial');
	}

	/**
	 * @param Account $account
	 */
	public function pollute(Account $account) {
		$this->condition = $account->repair();
		$this->money = $account->money()->value();
	}

	/**
	 * @return float percentage
	 */
	public function condition() {
		return $this->condition;
	}

	/**
	 * @return int
	 */
	public function money() {
		return $this->money;
	}
}