<?php

class Bars extends AccountSubclass {
	/**
	 * @return string
	 */
	public function experienceBar() {
		$account = $this->account();

		$levelProgress = $account->levelProgress();

		$offset = $levelProgress->levelExperience(true);

		return Plugins::statusBar(
			'experience',
			$levelProgress->levelExperience() - $offset,
			$account->experience() - $offset
		);
	}

	/**
	 * @return string
	 */
	public function conditionBar() {
		$condition = $this->account()->starship()->condition();
		$maximum = $condition->conditionMaximum();
		$current = $condition->conditionCurrent();

		return Plugins::statusBar('condition', $maximum, $current);
	}

	/**
	 * @return string
	 */
	public function shieldBar() {
		$starship = $this->account()->starship();
		$max = $starship->hasShield()
			? $starship->shield()->shieldMaxStrength()
			: 0;

		return Plugins::statusBar('shield', $max, 0);
	}

	/**
	 * @return string
	 */
	public function energyBar() {
		$max = $this->account()->starship()->capacity();
		$current = $max; // Fill with account value;

		return Plugins::statusBar('energy', $max, $current);
	}

	/**
	 * @return string
	 */
	public function enduranceBar() {
		$account = $this->account();

		return Plugins::statusBar(
			'endurance',
			$account->maxEndurance(),
			$account->realEndurance()
		);
	}

	/**
	 * @return string
	 */
	public function actionPointsBar() {
		$account = $this->account();

		return Plugins::statusBar(
			'condition',
			$account->maxActionPoints(),
			$account->realActionPoints()
		);
	}

	/**
	 * @return string
	 */
	public function tacticsProgress() {
		$account = $this->account();

		return Plugins::statusBar(
			'tacticsProgress',
			$account->factory()->actionAcademyTraining('tactics')->neededExperience(),
			$account->tacticsExperience()
		);
	}

	/**
	 * @return string
	 */
	public function defenseProgress() {
		$account = $this->account();

		return Plugins::statusBar(
			'defenseProgress',
			$account->factory()->actionAcademyTraining('defense')->neededExperience(),
			$account->defenseExperience()
		);
	}

	/**
	 * @return string
	 */
	public function craftingProgress() {
		$account = $this->account();

		return Plugins::statusBar(
			'tacticsProgress',
			$account->factory()->actionAcademyTraining('crafting')->neededExperience(),
			$account->craftingExperience()
		);
	}
}