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
}