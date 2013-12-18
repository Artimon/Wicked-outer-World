<?php

/**
 * Base functionality for starbase modules.
 *
 * Trade Port (= shopping centre) "Starbase *name* has no trade port."
 *  -> Scrap dealer (= second-hand-market)
 *  -> Defense systems (= armor shop)
 *  -> Weapon systems (= weapon shop)
 *  -> Drug store (= drug store) regain energy for loads of money
 *  -> Junkyard (trash items)
 * Space academy
 *  -> train skills for AP
 *  -> take lessons to increase AP
 *  -> expensive boosters, stealth and so on
 */
abstract class Starbase_Module_Abstract implements Starbase_Module_Interface {
	/**
	 * @var int
	 */
	private $level = 0;

	/**
	 * Override to activate menu spacers.
	 * Spacers are prepended to the module it is applied to.
	 *
	 * @var bool
	 */
	protected $menuSpacer = false;

	/**
	 * @param int $level
	 */
	public function __construct($level = 0) {
		$this->level = (int)$level;
	}

	/**
	 * @return array
	 */
	public function __toArray() {
		return array(
			'name' => $this->name(),
			'level' => $this->level()
		);
	}

	/**
	 * @return int
	 */
	public function level() {
		return $this->level;
	}

	/**
	 * @return bool
	 */
	public function menuSpacer() {
		return $this->menuSpacer;
	}
}