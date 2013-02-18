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
abstract class StarbaseModuleAbstract implements StarbaseModuleInterface {
	/**
	 * Override to activate menu spacers.
	 * Spacers are prepended to the module it is applied to.
	 *
	 * @var bool
	 */
	protected $menuSpacer = false;

	/**
	 * @return bool
	 */
	public function menuSpacer() {
		return $this->menuSpacer;
	}
}