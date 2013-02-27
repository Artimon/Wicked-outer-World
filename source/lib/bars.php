<?php

class Bars extends AccountSubclass {
	/**
	 * @return string
	 */
	public function experienceBar() {
		$account = $this->account();

		return Plugins::statusBar(
			'experience',
			$account->levelProgress()->nextLevelExperience(),
			$account->experience()
		);
	}

	/**
	 * @return string
	 */
	public function conditionBar() {
		$starship = $this->account()->starship();
		$max = $starship->structure() + $starship->armor();
		$current = $max;	// Fill with account value;

		return Plugins::statusBar('condition', $max, $current);
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
		$max = $this->account()->starship()->engine()->capacity();
		$current = $max;	// Fill with account value;

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
			$account->endurance()
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
			$account->actionPoints()
		);
	}

	/**
	 * @return string
	 */
	public function tacticsProgress() {
		$account = $this->account();

		return Plugins::statusBar(
			'tacticsProgress',
			$account->factory()->actionAcademyTraining()->neededTacticsExperience(),
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
			$account->factory()->actionAcademyTraining()->neededDefenseExperience(),
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
			$account->factory()->actionAcademyTraining()->neededCraftingExperience(),
			$account->craftingExperience()
		);
	}
}