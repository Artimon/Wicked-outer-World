<?php

class Sector_AsteroidField extends Sector_Abstract {
	const KEY = 1;

	/**
	 * @return string
	 */
	public function name() {
		return 'asteroidField';
	}

	/**
	 * @param Starbase $starbase
	 */
	protected function addModules(Starbase $starbase) {
		$starbase
			->addModule(new Starbase_Module_Quarters())
			->addModule(new Starbase_Module_JumpGate())
			->addModule(new Starbase_Module_Bank())
			->addModule(new Starbase_Module_Factory()) // 8
			->addModule(new Starbase_Module_Hangar())
			->addModule(new Starbase_Module_Skirmish());
	}

	/**
	 * @return int[]
	 */
	public function starTravelItems() {
		return array(
			CRYSTALS_ID				=> 20,
			WATER_ID				=> 55,	// 35%
			SPACE_JUNK_ID			=> 75,	// 20%
			TECHNICAL_COMPONENTS_ID	=> 90,	// 15%
			ENERGY_CELLS_ID			=> 100	// 10%
		);
	}

	/**
	 * @return int
	 */
	public function x() {
		return 250;
	}

	/**
	 * @return int
	 */
	public function y() {
		return 170;
	}

	/**
	 * @return int
	 */
	public function unlockPrice() {
		return 0;
	}

	/**
	 * @return int
	 */
	public function unlockLevel() {
		return 0;
	}
}