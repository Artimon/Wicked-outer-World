<?php

class Money extends AccountSubclass {
	/**
	 * @return int
	 */
	public function value() {
		$money = (int)$this->account()->value('money');

		if ($money < 0) {
			$money = 0;
			$this->account()->setValue('money', $money)->update();
		}

		return $money;
	}

	/**
	 * @return string
	 */
	public function short() {
		return Format::money($this->value());
	}

	/**
	 * @return string
	 */
	public function long() {
		return Format::money($this->value(), false);
	}

	/**
	 * @return int
	 */
	public function premiumCoins() {
		return (int)$this->account()->value('premiumCoins');
	}
}
