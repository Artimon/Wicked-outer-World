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
		return Plugins::statusBar(
			'condition',
			100,
			75
		);
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
			$account->actionAcademyTraining()->neededTacticsExperience(),
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
			$account->actionAcademyTraining()->neededDefenseExperience(),
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
			$account->actionAcademyTraining()->neededCraftingExperience(),
			$account->craftingExperience()
		);
	}
}