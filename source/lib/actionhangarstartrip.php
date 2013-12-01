<?php

class ActionHangarStarTrip extends ActionAbstract {
	const ENDURANCE_DRAIN = 5;

	/**
	 * @return bool
	 */
	public function hasEndurance() {
		return ($this->account()->realEndurance() >= self::ENDURANCE_DRAIN);
	}

	/**
	 * @return bool
	 */
	public function hasEngine() {
		return !$this->account()->starship()->engine()->isEmpty();
	}

	/**
	 * @return bool
	 */
	public function canStart() {
		return ($this->hasEndurance() && $this->hasEngine());
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
