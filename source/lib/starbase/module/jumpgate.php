<?php

/**
 * Factory module for starbases.
 */
class Starbase_Module_JumpGate extends Starbase_Module_Abstract {
	/**
	 * @var bool
	 */
	protected $menuSpacer = true;

	/**
	 * @return string
	 */
	public function name() {
		return 'jumpGate';
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'jumpGate';
	}
}
