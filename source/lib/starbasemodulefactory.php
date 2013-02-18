<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleFactory extends StarbaseModuleAbstract {
	/**
	 * @var bool
	 */
	protected $menuSpacer = true;

	/**
	 * @return string
	 */
	public function name() {
		return i18n('factory');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'factory';
	}
}
