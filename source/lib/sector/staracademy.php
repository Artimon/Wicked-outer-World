<?php

class Sector_StarAcademy extends Sector_Abstract {
	const KEY = 3;

	/**
	 * @return string
	 */
	public function name() {
		return 'starAcademy';
	}

	/**
	 * @param Starbase $starbase
	 */
	protected function addModules(Starbase $starbase) {
		$starbase
			->addModule(new Starbase_Module_Quarters())
			->addModule(new Starbase_Module_Academy(21))
			->addModule(new Starbase_Module_JumpGate())
			->addModule(new Starbase_Module_Bank())
			->addModule(new Starbase_Module_Hangar())
			->addModule(new Starbase_Module_Skirmish());
	}

	/**
	 * @return int[]
	 */
	public function starTravelItems() {
		return array(
			SPACE_JUNK_ID	=> 40,
			WATER_ID		=> 60,	// 20%
			FOOD_ID			=> 75,	// 15%
			ENERGY_CELLS_ID	=> 85,	// 10%
			ELECTRONICS_ID	=> 100	// 15%
		);
	}

	/**
	 * @return int
	 */
	public function x() {
		return 210;
	}

	/**
	 * @return int
	 */
	public function y() {
		return 235;
	}

	/**
	 * @return int
	 */
	public function unlockPrice() {
		return 5;
	}

	/**
	 * @return int
	 */
	public function unlockLevel() {
		return 6;
	}
}