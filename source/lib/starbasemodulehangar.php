<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleHangar extends StarbaseModuleAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('hangar');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'hangar';
	}
}