<?php

/**
 * Factory module for starbases.
 */
class StarbaseModuleAcademy extends StarbaseModuleAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('academy');
	}

	/**
	 * @return string
	 */
	public function route() {
		return 'academy';
	}
}