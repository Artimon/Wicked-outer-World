<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleFight extends StarbaseModuleAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('fight');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'fight';
	}
}