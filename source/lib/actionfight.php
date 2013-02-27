<?php

class ActionFight {
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
	 * @param Starship $aggressor
	 * @param Starship $victim
	 */
	public function __construct(Starship $aggressor, Starship $victim) {
		$this->aggressor = $aggressor;
		$this->victim = $victim;
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
	 * @return string
	 */
	public function start() {
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

		$victimName = $this->victim->account()->name();
		if ($this->isWinner()) {
			$plunder = new ActionFightPlunder();
			$money = $plunder->commit($this->aggressor, $this->victim);
			$money = Format::money($money);

			if ($aggressorCondition->conditionPercentage() > 20) {
				return i18n('skirmishWellWon', $victimName, $money);
			}

			return i18n('skirmishCloseWon', $money, $victimName);
		}

		return i18n('skirmishLost', $victimName);
	}
}
