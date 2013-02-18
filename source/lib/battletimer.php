<?php

/**
 * Handles timing of weapons, shields and stuff.
 * Uses further classes to do the specific jobs.
 *
 * Add this:
 * data-techId='{$techId}'
 * javaScript::create()->bind("$('.techInfo').techInfo();");
 */
class battleTimer extends starshipSubclass {
	/**
	 * @var int
	 */
	private $energy = 0;

	/**
	 * @var int
	 */
	private $recharge = 0;

	/**
	 * @var int
	 */
	private $capacity = 0;

	/**
	 * @var array
	 */
	private $weapons = array();

	/**
	 * @var technology
	 */
	private $shield;

	/**
	 * @var starship
	 */
	private $opponent;

	/**
	 * @var accuracy
	 */
	private $accuracy;

	/**
	 * Init energy and timer for weapons.
	 */
	public function init() {
		$starship = $this->starship();

		$this->recharge = $starship->rechargePerRound();
		$this->capacity = $starship->capacity();
		$this->energy = $this->capacity;
		$this->shield = $starship->shield();

		$weaponry = $starship->weaponry()->items();
		/* @var technology $technology */
		foreach ($weaponry as $technology) {
			for ($i = $technology->amount(); $i > 0; --$i) {
				$weapon = new stdClass();
				$weapon->item = $technology;
				$weapon->tick = 1 + rand(1, $technology->reload());

				$this->weapons[] = $weapon;
			}
		}
	}

	/**
	 * @param null|starship $starship
	 * @return null|starship
	 */
	public function opponent(starship $starship = null) {
		if ($starship) {
			$this->opponent = $starship;
			return null;
		}

		return $this->opponent;
	}

	/**
	 * @return accuracy
	 */
	public function accuracy() {
		if ($this->accuracy === null) {
			$this->accuracy = new accuracy($this);
		}

		return $this->accuracy;
	}

	/**
	 * @return renderBattle
	 */
	public function renderBattle() {
		return renderBattle::create();
	}

	/**
	 * @param technology $item
	 */
	private function weaponAction(technology $item) {
		$battleRenderer = $this->renderBattle();
		$battleRenderer->newEvent(
			$this->starship()->account(),
			$item,
			'firingWeapon'
		);

		$hits = $this->accuracy()->hits(
			$this->starship(),
			$this->opponent(),
			$item
		);

		$showShieldCollapsed = false;

		if ($hits['total'] === 0) {
			$battleRenderer->addEventInfo('missed', 'critical');
		} else {
			if ($item->burst() > 1) {
				if ($hits === 1) {
					$battleRenderer->addEventInfo('hitOnce', 'variable');
				} else {
					$battleRenderer->addEventInfo(
						'hitSeveralTimes',
						'variable',
						$hits['total']
					);
				}
			}

			$condition = $this->opponent()->condition();
			$shieldActivated = $condition->isShieldActivated();

			$damages = array(
				'partShield'	=> 0,
				'partCockpit'	=> 0,
				'partWeaponry'	=> 0,
				'partBody'		=> 0,
				'partEngine'	=> 0
			);

			foreach ($hits['parts'] as $part => $amount) {
				if ($amount === 0) {
					continue;
				}

				/*
				 * As soon as the shields collapse, the real part
				 * aimed part is used again.
				 */
				if ($condition->isShieldActivated()) {
					$part = 'partShield';
				}

				$damage = $condition->addDamage(
					$item,
					$amount
				);

				$damages[$part] += $damage;

				$this->starship()->account()->stats()->addInflictedDamage($damage);
			}

			foreach ($damages as $part => $damage) {
				if (0 === $damage) {
					continue;
				}

				$battleRenderer->addEventInfo(
					'xDamage',
					'highlight',
					$damage,
					$part,
					true
				);
			}

			if ($shieldActivated && !$condition->isShieldActivated()) {
				$showShieldCollapsed = true;
			}
		}

		$battleRenderer->commitEvent();

		if ($showShieldCollapsed) {
			$this->starship()->battleTimer()->renderBattle()
				->newEvent(
					$this->opponent()->account(),
					$this->opponent()->shield(),
					'shieldCollapsed',
					'critical'
				)
				->commitEvent();
		}
	}

	/**
	 * @return float
	 */
	private function energyLevelPercentage() {
		return round(100 * ($this->energy / $this->capacity));
	}

	private function fireWeapons() {
		foreach ($this->weapons as $weapon) {
			/* @var technology $item */
			$item = $weapon->item;

			if (--$weapon->tick > 0) {
				// Not ready to fire yet.
				continue;
			}

			$drain = $item->drain();
			if ($this->energy < $drain) {
				$energyLevel = $this->energyLevelPercentage();

				$this->renderBattle()
					->newEvent(
						$this->starship()->account(),
						$item,
						'insufficientEnergyWeapon',
						'critical'
					)
					->addEventInfo("({$energyLevel}%)", 'critical')
					->commitEvent();
				continue;
			}

			$this->energy -= $drain;
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
			$this->energy = $condition->rechargeShield($this->energy);
		} else {
			$drain = $this->shield->shieldBuildUpDrain();
			if ($this->energy < $drain) {
				$energyLevel = $this->energyLevelPercentage();

				$this->renderBattle()
					->newEvent(
						$this->starship()->account(),
						$this->shield,
						'insufficientEnergyShield',
						'critical'
					)
					->addEventInfo("({$energyLevel}%)", 'critical')
					->commitEvent();
			} else {
				$this->energy -= $drain;
				$condition->activateShield();

				$this->renderBattle()
					->newEvent(
						$this->starship()->account(),
						$this->shield,
						'shieldActivated'
					)
					->commitEvent();
			}
		}
	}

	/**
	 * @param starship $opponent
	 */
	public function nextRound(starship $opponent) {
		$this->energy = min(
			$this->capacity,
			$this->energy + $this->recharge
		);

		// Toggle call order for different setup.
		$this->fireWeapons();
		$this->powerUpShield();
	}
}

abstract class battleTimerSubclass {
	/**
	 * @var battleTimer
	 */
	private $battleTimer;

	/**
	 * @param battleTimer $battleTimer
	 */
	public function __construct(battleTimer $battleTimer) {
		$this->battleTimer = $battleTimer;
	}

	/**
	 * @return battleTimer
	 */
	public function battleTimer() {
		return $this->battleTimer;
	}
}