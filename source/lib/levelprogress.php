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

		if ($this->currentLevelExperience() >= $this->nextLevelExperience()) {
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
	 * @return int
	 */
	public function nextLevelExperience() {
		$x = $this->account()->level();

		$y = 500;
		$y += 107 * $x;
		$y += 243 * $x * $x;

		return $y;
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
