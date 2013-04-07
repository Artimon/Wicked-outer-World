<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleBank extends StarbaseModuleAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('bank');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'bank';
	}
}