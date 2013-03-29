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
	 * @param stdClass $element
	 * @param float $percentage
	 */
	protected function setCurrent(stdClass $element, $percentage) {
		$value = $element->max * $percentage;
		$value = round($value / 100);

		$element->current = $value;
	}

	/**
	 * @return void
	 */
	public function init() {
		$starship = $this->starship();
		$repair = $starship->repair();

		$this->structure = new stdClass();
		$this->structure->max = $starship->structure();
		$this->setCurrent($this->structure, $repair);

		$this->armor = new stdClass();
		$this->armor->max = $starship->armor();
		$this->setCurrent($this->armor, $repair);

		$this->shield = new stdClass();
		$this->shield->max = 0;
		$this->shield->current = 0;
		$this->shield->item = $starship->shield();
		if ($this->shield->item) {
			/* @var Technology $this->shield->item */
			$this->shield->max = $this->shield->item->shieldMaxStrength();
		}

		$this->energy = new stdClass();
		$this->energy->max = $starship->capacity();
		$this->energy->current = $this->energy->max;
		$this->energy->recharge = $starship->rechargePerRound();
	}

	/**
	 * Sets current repair state to starship (account).
	 */
	public function applyDamage() {
		$repair = $this->conditionPercentage();	// Current value.
		$repair -= $this->starship()->repair();	// Subtract initial value o get negative difference.

		$this->starship()->addDamage($repair);

		return $this;
	}

	/**
	 * @return int
	 */
	public function conditionMaximum() {
		return ($this->structure->max + $this->armor->max);
	}

	/**
	 * @return int
	 */
	public function conditionCurrent() {
		return ($this->structure->current + $this->armor->current);
	}

	/**
	 * @param stdClass $thing
	 * @return float
	 */
	private function percentage(stdClass $thing) {
		if ($thing->max <= 0) {
			return 0;
		}

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
		$condition = $this->structurePercentage();

		if ($this->armor->max > 0) {
			$condition += $this->armorPercentage();
			$condition = round($condition / 2);;
		}

		return $condition;
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
	 * @param Technology $shield
	 */
	public function activateShield(Technology $shield) {
		if (!$this->canActivateShield($shield)) {
			return;
		}

		$this->energy->current -= $shield->shieldBuildUpDrain();
		$this->shield->current = $this->shield->max;
	}

	/**
	 * @param Technology $shield
	 * @return bool
	 * @throws InvalidArgumentException
	 */
	public function canActivateShield(Technology $shield) {
		if (!$shield->isShield()) {
			throw new InvalidArgumentException('Item is no shield.');
		}

		return ($this->energy->current >= $shield->shieldBuildUpDrain());
	}

	/**
	 * @return int
	 */
	public function rechargeShield() {
		/* @var Technology $shield */
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
	 * @param Technology $item
	 * @param int $hits
	 * @return int inflicted damage
	 */
	public function addDamage(Technology $item, $hits) {
		// Shields: absorb integers like ultima online armor from 0 to x
		$damage = $item->damage() * $hits;
		$damage = round($damage * math::create()->gaussFactor());

		if ($this->isShieldActivated()) {
			/* @var Technology $shield */
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