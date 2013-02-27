<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleSkirmish extends StarbaseModuleAbstract {
	/**
	 * @var bool
	 */
	protected $menuSpacer = true;

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
		return 'skirmish';
	}
}