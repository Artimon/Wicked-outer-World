<?php

class ActionAcademyTraining extends ActionAbstract {
	const TYPE_TACTICS	= 'tactics';
	const TYPE_DEFENSE	= 'defense';
	const TYPE_CRAFTING	= 'crafting';

	const DRAIN_ACTION_POINTS	= 2;
	const DRAIN_ENDURANCE		= 7;

	/**
	 * @var int
	 */
	private $type;

	/**
	 * @var int
	 */
	private $neededExperience = 0;

	/**
	 * @return int
	 */
	public function experienceGain() {
		$account = $this->account();

		$experience = 1.5 * $account->endurance() + $account->maxEndurance();
		$experience = (int)($experience / 3);

		return $experience;
	}

	public function startTactics() {
		$this->type = self::TYPE_TACTICS;
		$this->neededExperience = $this->neededTacticsExperience();
		$this->start();
	}

	public function startDefense() {
		$this->type = self::TYPE_DEFENSE;
		$this->neededExperience = $this->neededDefenseExperience();
		$this->start();
	}

	public function startCrafting() {
		$this->type = self::TYPE_CRAFTING;
		$this->neededExperience = $this->neededCraftingExperience();
		$this->start();
	}

	/**
	 * @TODO Create formula.
	 *
	 * Note:
	 * Used within the self::needed***Experience() function.
	 * As a result, access self::neededExperience.
	 *
	 * @param int $level
	 * @return int
	 */
	protected function neededExperience($level) {
		return (50 * pow(1.3, $level));
	}

	/**
	 * @return int
	 */
	public function neededTacticsExperience() {
		return $this->neededExperience(
			$this->account()->tacticsLevel()
		);
	}

	/**
	 * @return int
	 */
	public function neededDefenseExperience() {
		return $this->neededExperience(
			$this->account()->defenseLevel()
		);
	}

	/**
	 * @return int
	 */
	public function neededCraftingExperience() {
		return $this->neededExperience(
			$this->account()->craftingLevel()
		);
	}

	/**
	 * @return bool
	 */
	public function canStart() {
		$account = $this->account();

		return (
			($account->endurance() >= self::DRAIN_ENDURANCE) &&
			($account->actionPoints() >= self::DRAIN_ACTION_POINTS)
		);
	}

	public function start() {
		if (!$this->canStart()) {
			EventBox::get()->failure(
				i18n('cannotStartTraining')
			);

			return;
		}

		$account = $this->account();

		$experience = $this->experienceGain();

		$expKey = $this->type . 'Experience';
		$newExperience = $account->value($expKey) + $experience;

		if ($newExperience >= $this->neededExperience) {
			$experience = $newExperience - $this->neededExperience;

			$account
				->setValue($expKey, 0)
				->increment($this->type . 'Level', 1);

			$message = i18n('levelGain');
			EventBox::get()->success($message);
		}
		else {
			$message = i18n('experienceGain', $experience);
			EventBox::get()->success($message);
		}

		$account
			->incrementEndurance(-self::DRAIN_ENDURANCE)
			->incrementActionPoints(-self::DRAIN_ACTION_POINTS)
			->increment($expKey, $experience)
			->update();
	}
}
