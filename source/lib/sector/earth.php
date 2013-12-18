<?php
/**
 * Created by PhpStorm.
 * User: Pascal
 * Date: 10.12.13
 * Time: 12:36
 */

class Sector_Earth extends Sector_Abstract {
	const KEY = 0;

	/**
	 * @return string
	 */
	public function name() {
		return 'earth';
	}

	/**
	 * @param Starbase $starbase
	 */
	protected function addModules(Starbase $starbase) {
		$starbase
			->addModule(new Starbase_Module_Quarters())
			->addModule(new Starbase_Module_Academy(10))
			->addModule(new Starbase_Module_JumpGate())
			->addModule(new Starbase_Module_Bank())
			->addModule(new Starbase_Module_TradeDeck(6))
			->addModule(new Starbase_Module_Factory(7))
			->addModule(new Starbase_Module_Hangar())
			->addModule(new Starbase_Module_Skirmish());
	}

	/**
	 * @return int
	 */
	public function x() {
		return 200;
	}

	/**
	 * @return int
	 */
	public function y() {
		return 220;
	}

	/**
	 * @return int
	 */
	public function unlockPrice() {
		return 0;
	}
}