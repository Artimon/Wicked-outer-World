<?php

/**
 * Factory module for starbases.
 */
class Starbase_Module_Hangar extends Starbase_Module_Abstract {
	/**
	 * @return string
	 */
	public function name() {
		return 'hangar';
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'hangar';
	}
}