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

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var StarbaseModuleInterface[]
	 */
	private $modules = array();


	/**
	 * @param int $starbaseId
	 */
	public function __construct($starbaseId) {
		$this->id = (int)$starbaseId;
	}

	/**
	 * @return string
	 */
	public function name() {
		return i18n('enigmaStarbase');
	}

	/**
	 * @return StarbaseModuleAbstract[]
	 */
	public function modules() {
		return array(
			new StarbaseModuleQuarters(),
			new StarbaseModuleAcademy(),
			new StarbaseModuleJumpGate(),
			new StarbaseModuleTradeDeck(),
			new StarbaseModuleFactory(),
			new StarbaseModuleHangar(),
			new StarbaseModuleFight()
		);
	}
}