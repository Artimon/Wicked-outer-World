<?php

class Bank extends AccountSubclass {
	/**
	 * @return bool
	 */
	public function hasAccount() {
		return ($this->value() >= 0);
	}

	/**
	 * @return bool
	 */
	public function canAfford() {
		return $this->account()->price()->set(
			$this->createAccountPrice()
		)->canAfford();
	}

	/**
	 * @return int
	 */
	public function createAccountPrice() {
		return 1500;
	}

	/**
	 * @return int
	 */
	public function transferFee() {
		return 50;
	}

	public function createAccount() {
		if ($this->hasAccount()) {
			return;
		}

		$account = $this->account();
		$price = $account->price();
		$price->set($this->createAccountPrice());

		if (!$price->canAfford()) {
			EventBox::get()->failure(
				i18n('youArePoor')
			);

			return;
		}

		$price->buy();
		$account->setValue('bank', 0)->update();

		EventBox::get()->success(
			i18n('bankAccountCreated')
		);
	}

	/**
	 * @param int $amount
	 */
	public function in($amount) {
		$amount = (int)max(0, $amount);
		if ($amount === 0) {
			return;
		}

		$account = $this->account();
		$result = $account->money()->value();
		$result -= $amount;
		$result -= $this->transferFee();

		if ($result < 0) {
			EventBox::get()->failure(
				i18n('notEnoughMoney')
			);

			return;
		}

		$account
			->setValue('money', $result)
			->increment('bank', $amount)
			->update();

		EventBox::get()->success(
			i18n('depositSuccess', Format::money($amount))
		);
	}

	public function out($amount) {
		$amount = (int)max(0, $amount);
		if ($amount === 0) {
			return;
		}

		$account = $this->account();
		$price = $account->price()->set(
			$this->transferFee()
		);

		if (!$price->canAfford() || ($this->value() < $amount)) {
			EventBox::get()->failure(
				i18n('notEnoughMoney')
			);

			return;
		}

		$price->buy();

		$account
			->increment('money', $amount)
			->decrement('bank', $amount)
			->update();

		EventBox::get()->success(
			i18n('drawSuccess', Format::money($amount))
		);
	}

	/**
	 * @return int
	 */
	public function value() {
		return (int)$this->account()->value('bank');
	}
}