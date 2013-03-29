<?php

class LevelProgress extends AccountSubclass {
	/**
	 * @param int $amount
	 * @return $this
	 */
	public function addExperience($amount) {
		$amount = (int)$amount;

		$account = $this->account();
		$account->increment('experience', $amount);

		if ($this->currentLevelExperience() >= $this->levelExperience()) {
			$account->increment('level', 1);
		}

		return $this;
	}

	/**
	 * @return int
	 */
	public function currentLevelExperience() {
		return $this->account()->experience();
	}

	/**
	 * P1 (0 / 500)
	 * P2 (1 / 860)
	 * P3 (20 / 100000)
	 *
	 * @param bool $lastLevel
	 * @return int
	 */
	public function levelExperience($lastLevel = false) {
		$x = $this->account()->level();

		if ($lastLevel) {
			--$x;
		}

		if ($x < 0) {
			return 0;
		}

		$y = 500;
		$y += 107 * $x;
		$y += 243 * $x * $x;

		return $y;
	}

	/**
	 * @return int
	 */
	public function progress() {
		$offset		= $this->levelExperience(true);
		$current	= $this->currentLevelExperience() - $offset;
		$needed		= $this->levelExperience() - $offset;

		$factor = $current / $needed;
		return (int)round(100 * $factor);
	}
}
