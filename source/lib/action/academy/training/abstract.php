<?php

abstract class Action_Academy_Training_Abstract extends ActionAbstract {
	const DRAIN_ACTION_POINTS	= 2;
	const DRAIN_ENDURANCE		= 7;

	/**
	 * @return int
	 */
	public function experienceGain() {
		$account = $this->account();

		$experience = 1.5 * $account->realEndurance() + $account->maxEndurance();
		$experience = (int)($experience / 3);

		return $experience;
	}

	/**
	 * @return string
	 */
	abstract protected function key();

	/**
	 * @return int
	 */
	abstract protected function skillLevel();

	/**
	 * @return int
	 */
	public function neededExperience() {
		$experience = pow(1.3, $this->skillLevel());
		return (50 * $experience);
	}

	/**
	 * @return bool
	 */
	public function hasSufficientLevel() {
		$account = $this->account();
		$academy = $account->starbase()->module('academy');

		return $academy->level() > $this->skillLevel();
	}

	/**
	 * @return bool
	 */
	public function hasStats() {
		$account = $this->account();

		return
			($account->realEndurance() >= self::DRAIN_ENDURANCE) &&
			($account->realActionPoints() >= self::DRAIN_ACTION_POINTS);
	}

	/**
	 * @return bool
	 */
	public function canStart() {
		return ($this->hasSufficientLevel() && $this->hasStats());
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

		$key = $this->key();
		$levelKey = $key . 'Level';
		$experienceKey = $key . 'Experience';

		$newExperience = $account->get($experienceKey) + $experience;
		$neededExperience = $this->neededExperience();

		$message = i18n('experienceGain', $experience);
		if ($newExperience >= $neededExperience) {
			$experience = $newExperience - $neededExperience;

			$account
				->set($experienceKey, 0)
				->increment($levelKey, 1);

			$message = i18n('levelGain');
		}

		EventBox::get()->success($message);

		$account->stats()->addTraining();

		$account
			->incrementEndurance(-self::DRAIN_ENDURANCE)
			->incrementActionPoints(-self::DRAIN_ACTION_POINTS)
			->increment($experienceKey, $experience)
			->update();
	}
}
