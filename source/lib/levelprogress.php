<?php

class LevelProgress extends AccountSubclass {
	/**
	 * @return int
	 */
	public function currentLevelExperience() {
		return 0;
	}

	/**
	 * @return int
	 */
	public function nextLevelExperience() {
		return 500;
	}

	/**
	 * @return int
	 */
	public function progress() {
		$difference = $this->nextLevelExperience() - $this->currentLevelExperience();

		$factor = $this->account()->experience() / $difference;
		return (int)round(100 * $factor);
	}
}
