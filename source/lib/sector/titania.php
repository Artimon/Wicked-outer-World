<?php

class Sector_Titania extends Sector_Abstract {
	const KEY = 4;

	/**
	 * @return string
	 */
	public function name() {
		return 'titania';
	}

	/**
	 * @param Starbase $starbase
	 */
	protected function addModules(Starbase $starbase) {
		$starbase
			->addModule(new Starbase_Module_Quarters())
			->addModule(new Starbase_Module_JumpGate())
			->addModule(new Starbase_Module_Bank())
			->addModule(new Starbase_Module_Factory()) // 12?
			->addModule(new Starbase_Module_Hangar())
			->addModule(new Starbase_Module_Skirmish());
	}

	/**
	 * @return int[]
	 */
	public function starTravelItems() {
		return array(
			TOXIC_WASTE_ID			=> 40,
			PLASTICS_ID				=> 50,	// 10%
			TECHNICAL_COMPONENTS_ID	=> 60,	// 10%
			ENERGY_CELLS_ID			=> 70,	// 10%
			COOLANT_ID				=> 75,	// 5%
			EXPLOSIVES_ID			=> 85,	// 10%
			DEUTERIUM_ID			=> 90,	// 5%
			NOBLE_GAS_ID			=> 95,	// 5%
			FOOD_ID					=> 100	// 5%
		);
	}

	/**
	 * @return int
	 */
	public function x() {
		return 170;
	}

	/**
	 * @return int
	 */
	public function y() {
		return 275;
	}

	/**
	 * @return int
	 */
	public function unlockPrice() {
		return 10;
	}

	/**
	 * @return int
	 */
	public function unlockLevel() {
		return 7;
	}
}