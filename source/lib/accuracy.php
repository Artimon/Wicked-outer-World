<?php

class Accuracy {
	/**
	 * @var int
	 */
	private $chance;

	/**
	 * @var array
	 */
	private $hits = array();

	/**
	 * @var Starship
	 */
	private $firingStarship;

	/**
	 * @var Starship
	 */
	private $opponentStarship;

	/**
	 * @param \Starship $firingStarship
	 * @return $this
	 */
	public function setFiringStarship($firingStarship) {
		$this->firingStarship = $firingStarship;

		return $this;
	}

	/**
	 * @param \Starship $opponentStarship
	 * @return $this
	 */
	public function setOpponentStarship($opponentStarship) {
		$this->opponentStarship = $opponentStarship;

		return $this;
	}

	/**
	 * @param Technology $item
	 * @param bool $subtractAmmunition
	 * @return int
	 */
	public function maxShots(Technology $item, $subtractAmmunition = false) {
		$burst = $item->burst();

		$ammunition = $item->ammunitionItem();
		if ($ammunition) {
			$group = $this->firingStarship->ammunition();
			$techId = $ammunition->id();

			if ($group->hasItem($techId)) {
				$ammunition = $group->item($techId);
				$ammunitionAmount = $ammunition->amount();

				$burst = min($burst, $ammunitionAmount);
				if ($subtractAmmunition) {
					$ammunition->sub($burst);
				}
			}
			else {
				$burst = 0;
			}
		}

		return $burst;
	}

	/**
	 * @param Technology $item
	 * @param bool $subtractAmmunition
	 * @return int
	 */
	public function hits(Technology $item, $subtractAmmunition = false) {
		$this->hits = 0;

		/*
		 * $starship->maxWeight() for ship size (overall hit probability)
		 * $starship->weight() for maneuverability
		 */
		$this->hitSomething(
			$this->maxShots($item, $subtractAmmunition)
		);

		return $this->hits;
	}

	/**
	 * @param int $burst
	 */
	private function hitSomething($burst) {
		for ($i = 0; $i < $burst; ++$i) {
			$chance = $this->chance();
			if ($this->strike($chance)) {
				++$this->hits;
			}
		}
	}

	/**
	 * @param int $chance
	 * @return bool
	 */
	private function strike($chance) {
		return (rand(0, 99) < $chance);
	}

	/**
	 * Formula:
	 * P1: (100 / 50)
	 * P2: (70 / 75)
	 * P3: (0 / 100)
	 * f(x) = -0,0047619048x² - 0,0238095238x + 100
	 *
	 * @return int
	 */
	public function chance() {
		if ($this->chance === null) {
			$movability = $this->opponentStarship->movability();

			$this->chance =
				-0.0047619048 * ($movability * $movability) -
				0.0238095238 * $movability +
				100;

			$opponent = $this->opponentStarship->account();
			$defenseLevel = $opponent->defenseLevel() + $opponent->level() + 25;

			$firing = $this->firingStarship->account();
			$tacticsLevel = $firing->tacticsLevel() + $firing->level() + 25;

			$this->chance *= ($tacticsLevel / $defenseLevel);

			$this->chance = min(95, $this->chance);
			$this->chance = max(5, $this->chance);

			$this->chance = round($this->chance);
		}

		return $this->chance;
	}
}