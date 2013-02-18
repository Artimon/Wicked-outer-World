<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleTradeDeck extends StarbaseModuleAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('tradeDeck');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'tradeDeck';
	}
}