<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleQuarters extends StarbaseModuleAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('quarters');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'quarters';
	}
}
