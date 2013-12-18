<?php

/**
 * Factory module for starbases.
 */
class Starbase_Module_Bank extends Starbase_Module_Abstract {
	/**
	 * @return string
	 */
	public function name() {
		return 'bank';
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'bank';
	}
}