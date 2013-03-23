<?php

class ActionFight extends ActionAbstract {
	const ACTION_POINTS = 6;

	/**
	 * @var Starship
	 */
	private $aggressor;

	/**
	 * @var Starship
	 */
	private $victim;

	/**
	 * @var bool
	 */
	private $isWinner = false;

	/**
	 * @var array
	 */
	private $data = array();

	/**
	 * @param \Starship $aggressor
	 * @return $this
	 */
	public function setAggressor(Starship $aggressor) {
		$this->aggressor = $aggressor;

		return $this;
	}

	/**
	 * @param \Starship $victim
	 * @return $this
	 */
	public function setVictim(Starship $victim) {
		$this->victim = $victim;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function canStart() {
		return $this->hasActionPoints();
	}

	/**
	 * @return bool
	 */
	public function hasActionPoints() {
		$actionPoints = $this->aggressor->account()->actionPoints();

		return ($actionPoints >= self::ACTION_POINTS);
	}

	/**
	 * @return bool
	 */
	public function isWinner() {
		return $this->isWinner;
	}

	/**
	 * @return array
	 */
	public function jsonData() {
		return json_encode($this->data);
	}

	/**
	 * Extracts all messages from given json and builds up a translation
	 * reference list.
	 *
	 * @param string $json
	 * @return string
	 */
	public static function jsonTranslations($json) {
		$result = array('missed' => i18n('missed'));

		$data = json_decode($json, true);
		foreach ($data as $action) {
			$key = $action['m'];
			$translation = i18n($key);

			$result[$key] = $translation;
		}

		return json_encode($result);
	}

	/**
	 * @param Starship $starship
	 */
	public function update(Starship $starship) {
		$starship->ammunition()->update();
	}

	/**
	 * @return string
	 */
	public function start() {
		if (!$this->canStart()) {
			return '';
		}

		$account = $this->aggressor->account();
		$account->incrementActionPoints(-self::ACTION_POINTS);

		$aggressorTimer = new ActionFightTimer($this->aggressor, $this->victim);
		$aggressorTimer
			->init()
			->setAggressor();

		$victimTimer = new ActionFightTimer($this->victim, $this->aggressor);
		$victimTimer->init();

		$aggressorCondition = $this->aggressor->condition();
		$victimCondition = $this->victim->condition();

		$this->data = array();

		$rounds = 0;
		do {
			$aggressorTimer->nextRound();
			$aggressorData = $aggressorTimer->data();

			$this->data = array_merge($this->data, $aggressorData);

			if ($victimCondition->isDefeated()) {
				$this->isWinner = true;

				break;
			}


			$victimTimer->nextRound();
			$victimData = $victimTimer->data();

			$this->data = array_merge($this->data, $victimData);

			if ($aggressorCondition->isDefeated()) {
				break;
			}
		}
		while (++$rounds < 20);

		$aggressorCondition->applyDamage();
		$victimCondition->applyDamage();

		$victimName = $this->victim->account()->name();
		if ($this->isWinner()) {
			$plunder = new ActionFightPlunder();
			$money = $plunder->apply($this->aggressor, $this->victim);
			$money = Format::money($money);

			$experienceGain = 50;

			if ($aggressorCondition->conditionPercentage() > 20) {
				$message = i18n('skirmishWellWon', $victimName, $money);
			}
			else {
				$message = i18n('skirmishCloseWon', $money, $victimName);
			}
		}
		else {
			$experienceGain = 25;

			$message = i18n('skirmishLost', $victimName);
		}

		$account->levelProgress()->addExperience($experienceGain);

		$this->update($this->aggressor);
		$this->update($this->victim);

		return $message;
	}
}
