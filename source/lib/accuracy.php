<?php

class accuracy extends battleTimerSubclass {
	/**
	 * @var array
	 */
	private $hits = array();

	/**
	 * @param starship $firingStarship
	 * @param starship $opponentStarship
	 * @param technology $item
	 * @return array
	 */
	public function hits(
		starship $firingStarship,
		starship $opponentStarship,
		technology $item
	) {
		$this->hits = array(
			'total' => 0,
			'parts' => array(
				'partCockpit'	=> 0,
				'partWeaponry'	=> 0,
				'partBody'		=> 0,
				'partEngine'	=> 0
			)
		);

		/*
		 * @TODO calculate by skills
		 *
		 * $starship->maxWeight() for ship size (overall hit probability)
		 * $starship->weight() for maneuverability
		 */

		$targetId = $firingStarship->account()->targetId();
		if ($targetId) {
			$this->hitTargeted($opponentStarship, $item->burst(), $targetId);
		} else {
			$this->hitSomething($opponentStarship, $item->burst());
		}

		$parts = &$this->hits['parts'];
		$this->hits['total'] =
			$parts['partCockpit'] +
			$parts['partWeaponry'] +
			$parts['partBody'] +
			$parts['partEngine'];

		return $this->hits;
	}

	/**
	 * @param starship $starship
	 * @param int $burst
	 * @param int $targetId
	 */
	private function hitTargeted(
		starship $starship,
		$burst,
		$targetId
	) {
		$sizeConfig = $starship->sizeConfig();

		$baseAccuracy = $this->baseAccuracy($starship->size());
		$baseAccuracy -= 5;
		for ($i = 0; $i < $burst; ++$i) {
			if ($this->missed($baseAccuracy)) {
				continue;
			}

			switch ($targetId) {
				case 1:
					$accuracy = $sizeConfig->cockpit;
					$part = 'partCockpit';
					break;

				case 2:
					$accuracy = $sizeConfig->weaponry;
					$part = 'partWeaponry';
					break;

				case 3:
					$accuracy = $sizeConfig->body;
					$part = 'partBody';
					break;

				case 4:
					$accuracy = $sizeConfig->engine;
					$part = 'partEngine';
					break;

				default:
					$accuracy = -1000;
					$part = 'partBody';
			}

//			$accuracy += 15;
			if (rand(0, 99) < $accuracy) {
				++$this->hits['parts'][$part];
			} else {
				$this->singleHit($starship);
			}
		}
	}

	/**
	 * @param starship $starship
	 * @param int $burst
	 */
	private function hitSomething(
		starship $starship,
		$burst
	) {
		for ($i = 0; $i < $burst; ++$i) {
			$this->singleHit($starship);
		}
	}

	/**
	 * @param starship $starship
	 * @return void
	 */
	private function singleHit(starship $starship) {
		$chance = $this->baseAccuracy($starship->size());
		if ($this->missed($chance)) {
			return;
		}

		$sizeConfig = $starship->sizeConfig();

		$parts = &$this->hits['parts'];
		$random = rand(0, 99);

		$accuracy = $sizeConfig->cockpit;
		if ($random < $accuracy) {
			++$parts['partCockpit'];

			return;
		}

		$accuracy += $sizeConfig->weaponry;
		if ($random < $accuracy) {
			++$parts['partWeaponry'];

			return;
		}

		$accuracy += $sizeConfig->body;
		if ($random < $accuracy) {
			++$parts['partBody'];

			return;
		}

		++$parts['partEngine'];
	}

	/**
	 * @param int $chance
	 * @return bool
	 */
	private function missed($chance) {
		return !(rand(0, 99) < $chance);
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
