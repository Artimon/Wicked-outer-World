<?php

class Accuracy {
	/**
	 * @var array
	 */
	private $hits = array();

	/**
	 * @param Starship $firingStarship
	 * @param Starship $opponentStarship
	 * @param technology $item
	 * @return array
	 */
	public function hits(
		Starship $firingStarship,
		Starship $opponentStarship,
		technology $item
	) {
		$this->hits = 0;

		/*
		 * @TODO calculate by skills
		 *
		 * $starship->maxWeight() for ship size (overall hit probability)
		 * $starship->weight() for maneuverability
		 */


		$this->hitSomething($opponentStarship, $item->burst());

		return $this->hits;
	}

	/**
	 * @param Starship $starship
	 * @param int $burst
	 */
	private function hitSomething(
		Starship $starship,
		$burst
	) {
		$size = $starship->size();
		for ($i = 0; $i < $burst; ++$i) {
			$chance = $this->baseAccuracy($size);
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
	 * Size range:
	 * 1 very small part	15%
	 * 10 small fighter		60%
	 * 20 cruiser			85%
	 * 30 battleship?		99%
	 *
	 * @param int $size
	 * @return int
	 */
	private function baseAccuracy($size) {
		if ($size < 10) {
			return (10 + 5 * $size);
		}

		if ($size < 20) {
			$size -= 10;
			return (int)round(60 + 2.5 * $size);
		}

		$size -= 20;
		return (int)round(85 + 1.4 * $size);
	}
}