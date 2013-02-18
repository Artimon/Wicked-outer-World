<?php

class ActionHangarStarTrip extends ActionAbstract {
	const ENDURANCE_DRAIN = 5;

	/**
	 * @return bool
	 */
	public function canStart() {
		$endurance = $this->account()->endurance();

		return ($endurance >= self::ENDURANCE_DRAIN);
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
