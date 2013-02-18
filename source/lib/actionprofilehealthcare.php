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

		// @TODO Add reward (coins, money and a third one).
		$this->account()
			->setValue('lastHealthCare', TIME)
			->update();

		$this->eventBox()->success(
			i18n('healthCareReward')
		);
	}
}
