<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleJumpGate extends StarbaseModuleAbstract {
	/**
	 * @var bool
	 */
	protected $menuSpacer = true;

	/**
	 * @return string
	 */
	public function name() {
		return i18n('jumpGate');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'jumpGate';
	}
}
