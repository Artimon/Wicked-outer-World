<?php

/**
 * Factory module for starbases.
 */
class Starbase_Module_TradeDeck extends Starbase_Module_Abstract {
	const KEY = 'tradeDeck';

	/**
	 * @return string
	 */
	public function name() {
		return self::KEY;
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'tradeDeck';
	}
}