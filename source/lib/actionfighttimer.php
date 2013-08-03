<?php

/**
 * Handles timing of weapons, shields and stuff.
 * Uses further classes to do the specific jobs.
 *
 * Add this:
 * data-techId='{$techId}'
 * javaScript::create()->bind("$('.techInfo').techInfo();");
 */
class ActionFightTimer {
	const SIDE_AGGRESSOR = 'aggressor';
	const SIDE_VICTIM = 'victim';
	const EVENT_DELAY = 750;

	/**
	 * @var array
	 */
	private $weapons = array();

	/**
	 * @var Technology
	 */
	private $shield;

	/**
	 * @var bool
	 */
	private $aggressor = false;

	/**
	 * @var Starship
	 */
	private $starship;

	/**
	 * @var Starship
	 */
	private $opponent;

	/**
	 * @var Accuracy
	 */
	private $accuracy;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @param Starship $starship
	 * @param Starship $opponent
	 */
	public function __construct(Starship $starship, Starship $opponent) {
		$this->starship = $starship;
		$this->opponent = $opponent;
	}

	/**
	 * @return array
	 */
	public function data() {
		return $this->data;
	}

	/**
	 * Init energy and timer for weapons.
	 *
	 * @return ActionFightTimer
	 */
	public function init() {
		$starship = $this->starship();

		$this->shield = $starship->shield();

		$weaponry = $starship->weaponry()->items();
		/* @var Technology $technology */
		foreach ($weaponry as $technology) {
			for ($i = $technology->amount(); $i > 0; --$i) {
				$weapon = new stdClass();
				$weapon->item = $technology;
				$weapon->tick = 1 + rand(1, $technology->reload());

				$this->weapons[] = $weapon;
			}
		}

		return $this;
	}

	/**
	 * @return \Starship
	 */
	public function starship() {
		return $this->starship;
	}

	/**
	 * @return \Starship
	 */
	public function opponent() {
		return $this->opponent;
	}

	/**
	 * @return Accuracy
	 */
	public function accuracy() {
		if ($this->accuracy === null) {
			$this->accuracy = new Accuracy();
		}

		return $this->accuracy;
	}

	/**
	 * @return RenderFightData
	 */
	public function renderBattle() {
		return RenderFightData::get();
	}

	/**
	 * @return ActionFightTimer
	 */
	public function setAggressor() {
		$this->aggressor = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isAggressor() {
		return $this->aggressor;
	}

	/**
	 * @param $shotsLeft
	 * @return int
	 */
	private function attackDuration($shotsLeft) {
		return $shotsLeft > 1
			? 350
			: self::EVENT_DELAY;
	}

	/**
	 * @param Technology $item
	 */
	private function weaponAction(Technology $item) {
		$accuracy = $this->accuracy();
		$starship = $this->starship();
		$hits = $accuracy
			->setFiringStarship($starship)
			->setOpponentStarship($this->opponent())
			->hits($item);

		$total = $accuracy->maxShots($item);

		$missed = $total - $hits;

		$starship->account()->stats()
			->addHits($hits)
			->addMisses($missed);

		while ($missed-- > 0) {
			$this->newAttackEvent(
				'm',
				$item->nameRaw(),
				$this->attackDuration($total--)
			);
		}

		$condition = $this->opponent()->condition();
		$shieldActivated = $condition->isShieldActivated();

		$starshipStats = $starship->account()->stats();
		$opponentStats = $this->opponent()->account()->stats();
		while ($hits-- > 0) {
			$damage = $condition->addDamage($item, 1);

			$delay = $this->attackDuration($total--);
			if ($shieldActivated && !$condition->isShieldActivated()) {
				$shieldActivated = false;

				$this->newAttackEvent('d', $item->nameRaw(), 0, $damage);
				$this->newAttackEvent('sd', 'shieldDown', $delay);
			}
			else {
				$this->newAttackEvent('d', $item->nameRaw(), $delay, $damage);
			}

			$starshipStats->addInflictedDamage($damage);
			$opponentStats->addTakenDamage($damage);
		}
	}

	private function fireWeapons() {
		foreach ($this->weapons as $weapon) {
			/* @var Technology $item */
			$item = $weapon->item;

			// Not ready to fire yet.
			if (--$weapon->tick > 0) {
				continue;
			}

			$condition = $this->starship()->condition();

			$drain = $item->drain();
			if (!$condition->canDrainEnergy($drain)) {
				continue;
			}

			$condition->drainEnergy($drain);
			$weapon->tick = $item->reload();

			$this->weaponAction($item);
		}
	}

	private function powerUpShield() {
		if (!$this->shield) {
			return;
		}

		$condition = $this->starship()->condition();

		if ($condition->isShieldActivated()) {
			$power = $condition->rechargeShield();

			$this->newOwnEvent('sp', 'shieldPlus', self::EVENT_DELAY, $power);

			return;
		}

		if (!$condition->canActivateShield($this->shield)) {
			return;
		}

		$condition->activateShield($this->shield);

		$this->newOwnEvent('su', 'shieldUp');
	}

	private function recharge() {
		$energy = $this->starship()->condition()->rechargeEnergy();

		$this->newOwnEvent('r', 'recharge', self::EVENT_DELAY, $energy);
	}

	/**
	 * @param $side
	 * @param $action
	 * @param string $message
	 * @param int $delay
	 * @param int $value
	 */
	private function newEvent(
		$side,
		$action,
		$message,
		$delay,
		$value
	) {
		if ($value === 0) {
			return;
		}

		if ($this->isAggressor()) {
			$aggressor = $this->starship();
			$victim = $this->opponent();
		}
		else {
			$aggressor = $this->opponent();
			$victim = $this->starship();
		}

		$aggressorCondition = $aggressor->condition();
		$victimCondition = $victim->condition();

		$this->data[] = array(
			's' => (string)$side,
			'a' => (string)$action,
			'm' => (string)$message,
			'd' => (int)$delay,
			'v' => (int)$value,
			'ag' => array(
				'c' => $aggressorCondition->conditionPercentage(),
				's' => $aggressorCondition->shieldPercentage(),
				'e' => $aggressorCondition->energyPercentage()
			),
			'vi' => array(
				'c' => $victimCondition->conditionPercentage(),
				's' => $victimCondition->shieldPercentage(),
				'e' => $victimCondition->energyPercentage()
			)
		);
	}

	/**
	 * @param string $action
	 * @param string $message
	 * @param int $delay
	 * @param int $value
	 */
	private function newOwnEvent($action, $message, $delay = 750, $value = null) {
		$side = $this->isAggressor()
			? self::SIDE_AGGRESSOR
			: self::SIDE_VICTIM;

		$this->newEvent($side, $action, $message, $delay, $value);
	}

	/**
	 * @param string $action
	 * @param string $message
	 * @param int $delay
	 * @param int $value
	 */
	private function newAttackEvent($action, $message, $delay = 750, $value = null) {
		$side = $this->isAggressor()
			? self::SIDE_VICTIM
			: self::SIDE_AGGRESSOR;

		$this->newEvent($side, $action, $message, $delay, $value);
	}

	public function nextRound() {
		$this->data = array();

		$this->recharge();

		if ($this->starship()->account()->isEnergyToShields()) {
			$this->powerUpShield();
			$this->fireWeapons();
		}
		else {
			$this->fireWeapons();
			$this->powerUpShield();
		}
	}
}