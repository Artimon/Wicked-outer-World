<?php

class ActionProfileHealthCare extends AccountSubclass {
	/**
	 * @return bool
	 */
	public function canStart() {
		$lastTime = $this->account()->lastHealthCare();
		$halfDayPassed = ($lastTime + 40000) < TIME;

		$lastTime = (int)($lastTime / 86400);
		$now = (int)(TIME / 86400);
		$nextDay = $now > $lastTime;

		return ($nextDay && $halfDayPassed);
	}

	/**
	 * @return EventBox
	 */
	public function eventBox() {
		return EventBox::get();
	}

	/**
	 * @param bool $showEvent
	 */
	public function start($showEvent = true) {
		if (!$this->canStart()) {
			$this->eventBox()->failure(
				i18n('healthCareNotAvailableYet')
			);

			return;
		}

		$rewards = array(
			'money' => array(500, 100, 50),
			'premiumCoins' => array(3, 1),
			'experience' => array(100, 80, 50)
		);

		$account = $this->account();

		$reward = array_rand($rewards);
		$amount = array_rand($rewards[$reward]);
		$amount = $rewards[$reward][$amount];

		if ($reward === 'experience') {
			$account->levelProgress()->addExperience($amount);

			$message = $amount . ' ' . i18n('experience');
		}
		else {
			$account->increment($reward, $amount);

			$message = $reward === 'money'
				? Format::money($amount)
				: $amount . ' ' . i18n('premiumCoins');
		}

		$message = i18n('healthCareReward', $message);
		EventBox::get()->success($message);

		$account
			->setValue('lastHealthCare', TIME)
			->update();
	}
}
