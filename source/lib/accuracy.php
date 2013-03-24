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
	 * @return int
	 */
	public function maxShots(Technology $item) {
		$burst = $item->burst();

		$ammunition = $item->ammunition();
		if ($ammunition) {
			$group = $this->firingStarship->ammunition();
			$techId = $ammunition->id();

			$ammunitionAmount = 0;
			if ($group->hasItem($techId)) {
				$ammunition = $group->item($techId);
				$ammunitionAmount = $ammunition->amount();
			}

			$burst = min($burst, $ammunitionAmount);
		}

		return $burst;
	}

	/**
	 * @param Technology $item
	 * @return array
	 */
	public function hits(Technology $item) {
		$this->hits = 0;

		/*
		 * @TODO calculate by skills
		 *
		 * $starship->maxWeight() for ship size (overall hit probability)
		 * $starship->weight() for maneuverability
		 */
		$this->hitSomething(
			$this->maxShots($item)
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
	 * @return int
	 */
	private function chance() {
		if ($this->chance === null) {
			$this->chance = 100;
			$this->chance -= $this->opponentStarship->movability();	// Now 85% for example.

			$opponent = $this->opponentStarship->account();
			$defenseLevel = $opponent->defenseLevel() + $opponent->level() + 25;

			$firing = $this->firingStarship->account();
			$tacticsLevel = $firing->tacticsLevel() + $firing->level() + 25;

			$this->chance *= ($tacticsLevel / $defenseLevel);

			$this->chance = min(95, $this->chance);
			$this->chance = max(5, $this->chance);
		}

		return $this->chance;
	}
}