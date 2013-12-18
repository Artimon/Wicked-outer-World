<?php

/**
 * Factory module for starbases.
 */
class Starbase_Module_Skirmish extends Starbase_Module_Abstract {
	/**
	 * @return string
	 */
	public function name() {
		return 'fight';
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'skirmish';
	}
}