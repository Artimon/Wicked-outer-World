<?php

/**
 * Handles starship condition in common and current damages.
 */
class Condition extends StarshipSubclass {
	/**
	 * @var stdClass
	 */
	private $structure;

	/**
	 * @var stdClass
	 */
	private $armor;

	/**
	 * @var stdClass
	 */
	private $shield;

	/**
	 * @var stdClass
	 */
	private $energy;

	/**
	 * @return void
	 */
	public function init() {
		$starship = $this->starship();

		$this->structure = new stdClass();
		$this->structure->max = $starship->structure();
		$this->structure->current = $this->structure->max;

		$this->armor = new stdClass();
		$this->armor->max = $starship->armor();
		$this->armor->current = $this->armor->max;

		$this->shield = new stdClass();
		$this->shield->max = 0;
		$this->shield->current = 0;
		$this->shield->item = $starship->shield();
		if ($this->shield->item) {
			/* @var technology $this->shield->item */
			$this->shield->max = $this->shield->item->shieldMaxStrength();
		}

		$this->energy = new stdClass();
		$this->energy->max = $starship->capacity();
		$this->energy->current = $this->energy->max;
		$this->energy->recharge = $starship->rechargePerRound();
	}

	/**
	 * @param stdClass $thing
	 * @return float
	 */
	private function percentage(stdClass $thing) {
		$factor = $thing->current / $thing->max;
		return round(100 * $factor);
	}

	/**
	 * @return float
	 */
	public function structurePercentage() {
		return $this->percentage($this->structure);
	}

	/**
	 * @return float
	 */
	public function armorPercentage() {
		return $this->percentage($this->armor);
	}

	/**
	 * @return float
	 */
	public function conditionPercentage() {
		$condition = $this->structurePercentage() + $this->armorPercentage();

		return round($condition / 2);
	}

	/**
	 * @return float
	 */
	public function shieldPercentage() {
		if ($this->shield->max === 0) {
			return 0;
		}

		return $this->percentage($this->shield);
	}

	/**
	 * @return float
	 */
	public function energyPercentage() {
		return $this->percentage($this->energy);
	}

	/**
	 * @return bool
	 */
	public function isShieldActivated() {
		return ($this->shield->current > 0);
	}

	/**
	 * @param technology $shield
	 */
	public function activateShield(technology $shield) {
		if (!$this->canActivateShield($shield)) {
			return;
		}

		$this->energy->current -= $shield->shieldBuildUpDrain();
		$this->shield->current = $this->shield->max;
	}

	/**
	 * @param technology $shield
	 * @return bool
	 * @throws InvalidArgumentException
	 */
	public function canActivateShield(technology $shield) {
		if (!$shield->isShield()) {
			throw new InvalidArgumentException('Item is no shield.');
		}

		return ($this->energy->current >= $shield->shieldBuildUpDrain());
	}

	/**
	 * @return int
	 */
	public function rechargeShield() {
		/* @var technology $shield */
		$shield = $this->shield->item;

		if (!$shield) {
			return 0;
		}

		$discharge = $this->shield->max - $this->shield->current;
		if ($discharge === 0) {
			return 0;
		}

		$singleStrength = $shield->shieldStrengthPerEnergy();
		$singleEnergy = $shield->shieldRechargeDrain();

		$energyNeeded = ceil($discharge / $singleStrength);
		$energyNeeded = min($energyNeeded, $this->energy->current, $singleEnergy);

		$before = $this->shield->current;

		$this->shield->current = min(
			$this->shield->max,
			$this->shield->current + ($energyNeeded * $singleStrength)
		);

		$this->energy->current -= $energyNeeded;

		return (int)($this->shield->current - $before);
	}

	/**
	 * @param int $source
	 * @param int $damage
	 * @return int
	 */
	private function subtractFrom(&$source, $damage) {
		$amount = min($source, $damage);
		$source -= $amount;
		$damage -= $amount;

		return $damage;
	}

	/**
	 * @param int $amount
	 * @return Condition
	 */
	public function drainEnergy($amount) {
		$this->energy->current -= $amount;
		$this->energy->current = max(0, $this->energy->current);

		return $this;
	}

	/**
	 * @param $amount
	 * @return bool
	 */
	public function canDrainEnergy($amount) {
		return ($this->energy->current >= $amount);
	}

	/**
	 * @return int recharge value
	 */
	public function rechargeEnergy() {
		$previous = $this->energy->current;

		$this->energy->current += $this->energy->recharge;
		$this->energy->current = min(
			$this->energy->current,
			$this->energy->max
		);

		return ($this->energy->current - $previous);
	}

	/**
	 * @return bool
	 */
	public function isDefeated() {
		return ($this->structure->current <= 0);
	}

	/**
	 * @param technology $item
	 * @param int $hits
	 * @return int inflicted damage
	 */
	public function addDamage(technology $item, $hits) {
		// Shields: absorb integers like ultima online armor from 0 to x
		$damage = $item->damage() * $hits;
		$damage = round($damage * math::create()->gaussFactor());

		if ($this->isShieldActivated()) {
			/* @var technology $shield */
			$shield = $this->shield->item;

			$absorb = $shield->shieldAbsorb($item->damageType());
			$absorb = rand(0, $absorb);

			$damage -= $absorb;
		}

		$rest = $damage;
		$order = array($this->shield, $this->armor, $this->structure);
		foreach ($order as $source) {
			$rest = $this->subtractFrom($source->current, $rest);
			if ($rest <= 0) {
				break;
			}
		}

		return $damage;
	}
}