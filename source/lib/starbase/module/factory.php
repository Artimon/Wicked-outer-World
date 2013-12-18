<?php

/**
 * Factory module for starbases.
 */
class Starbase_Module_Factory extends Starbase_Module_Abstract {
	/**
	 * @var bool
	 */
	protected $menuSpacer = true;

	/**
	 * @return string
	 */
	public function name() {
		return 'factory';
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'factory';
	}
}
