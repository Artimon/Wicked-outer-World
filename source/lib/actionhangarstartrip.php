<?php

class ActionHangarStarTrip extends ActionAbstract {
	const ENDURANCE_DRAIN = 5;

	/**
	 * @return bool
	 */
	public function canStart() {
		$account = $this->account();

		$hasEndurance = ($account->endurance() >= self::ENDURANCE_DRAIN);
		$hasEngine = !$account->starship()->engine()->isEmpty();

		return ($hasEndurance && $hasEngine);
	}

	/**
	 * @throws Exception
	 */
	public function start() {
		if (!$this->canStart()) {
			throw new Exception('Star Trip cannot be started.');
		}

		$account = $this->account();
		$account->incrementEndurance(-self::ENDURANCE_DRAIN);
		$account->update();
	}
}
