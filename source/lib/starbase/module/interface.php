<?php

interface Starbase_Module_Interface {
	/**
	 * @return array
	 */
	public function __toArray();

	/**
	 * @return string
	 */
	public function name();

	/**
	 * @return int
	 */
	public function level();

	/**
	 * @return string
	 */
	public function route();

	/**
	 * @return bool
	 */
	public function menuSpacer();
}