<?php

/**
 * Can be configured with different modules.
 *
 * Starbase (= suburb) "You are currently on mission, return to base?"
 *  -> Quarters (= your home)
 *  -> Trade deck (= shopping centre)
 *  -> Jump gate (= travel) level requirements + money to pay
 *  -> Space academy (= education centre)
 *  -> Factory
 *  -> Hangar
 *  -> Space lounge (?)
 *  -> Space health care (random reward)
 */
class Starbase {
	const MODULE_QUARTERS		= 1;	// "home"
	const MODULE_TRADE_DECK		= 2;	// shopping centre
	const MODULE_ACADEMY		= 3;	// education centre
	const MODULE_JUMP_GATE		= 4;	// Due to difficulty and controlability.
	const MODULE_FACTORY		= 5;	// Fiddle, craft
	const MODULE_HANGAR			= 6;	// Design, start mission
	const MODULE_SOLAR_POWER	= 7;	// Buy energy cells
	const MODULE_LOUNGE			= 8;	// Quests?
	const MODULE_ASTROMETRICS	= 9;	// "astrometrisches Labor" = map
	const MODULE_BANK			= 10;

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var Starbase_Module_Interface[]
	 */
	private $modules = array();

	/**
	 * @var string
	 */
	private $name = '';


	/**
	 * @param int $starbaseId
	 * @param string $name
	 */
	public function __construct($starbaseId, $name) {
		$this->id = (int)$starbaseId;
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * @param Starbase_Module_Interface $module
	 * @return $this
	 */
	public function addModule(Starbase_Module_Interface $module) {
		$this->modules[] = $module;

		return $this;
	}

	/**
	 * @return Starbase_Module_Interface[]
	 */
	public function modules() {
		return $this->modules;
	}

	/**
	 * @param string $key
	 * @return null|Starbase_Module_Interface
	 */
	public function module($key) {
		foreach ($this->modules as $module) {
			if ($key === $module->name()) {
				return $module;
			}
		}

		return null;
	}
}