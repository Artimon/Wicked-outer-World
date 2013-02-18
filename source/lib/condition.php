<?php

/**
 * Handles starship condition in common and current damages.
 */
class condition extends starshipSubclass {
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
	 * @return void
	 */
	public function init() {
		$this->structure = new stdClass();
		$this->structure->max = $this->starship()->structure();
		$this->structure->current = $this->structure->max;

		$this->armor = new stdClass();
		$this->armor->max = $this->starship()->armor();
		$this->armor->current = $this->armor->max;

		$this->shield = new stdClass();
		$this->shield->max = 0;
		$this->shield->current = 0;
		$this->shield->item = $this->starship()->shield();
		if ($this->shield->item) {
			/* @var technology $this->shield->item */
			$this->shield->max = $this->shield->item->shieldMaxStrength();
		}
	}

	/**
	 * @return float
	 */
	public function structurePercentage() {
		$factor = $this->structure->current / $this->structure->max;
		return round(100 * $factor);
	}

	/**
	 * @return float
	 */
	public function armorPercentage() {
		$factor = $this->armor->current / $this->armor->max;
		return round(100 * $factor);
	}

	/**
	 * @return float
	 */
	public function shieldPercentage() {
		if ($this->shield->max === 0) {
			return 0;
		}

		$factor = $this->shield->current / $this->shield->max;
		return round(100 * $factor);
	}

	/**
	 * @return bool
	 */
	public function isShieldActivated() {
		return ($this->shield->current > 0);
	}

	public function activateShield() {
		$this->shield->current = $this->shield->max;
	}

	/**
	 * @param int $energyAvailable
	 * @return int
	 */
	public function rechargeShield($energyAvailable) {
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
		$energyNeeded = min($energyNeeded, $energyAvailable, $singleEnergy);

		$this->shield->current = min(
			$this->shield->max,
			$this->shield->current + ($energyNeeded * $singleStrength)
		);

		return $energyNeeded;
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
	 * @param string $part
	 * @param int $damage
	 */
	private function raiseCriticals($part, $damage) {

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

		if ($this->structure->current <= 0) {
//			echo $this->starship()->name().' destroyed<br>';
		}

		return $damage;
	}
}