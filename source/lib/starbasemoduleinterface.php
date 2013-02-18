<?php

interface StarbaseModuleInterface {
	/**
	 * @abstract
	 * @return string
	 */
	public function name();

	/**
	 * @abstract
	 * @return string
	 */
	public function route();
}