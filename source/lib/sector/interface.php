<?php

interface Sector_Interface {
	/**
	 * @return int
	 */
	public function key();

	/**
	 * @param Account $account
	 * @return Sector_Interface
	 */
	public static function getInstance(Account $account);

	/**
	 * @return Starbase
	 */
	public function starbase();

	/**
	 * @return string
	 */
	public function name();

	/**
	 * @return string
	 */
	public function description();

	/**
	 * @return int
	 */
	public function unlockPrice();

	/**
	 * @return int
	 */
	public function x();

	/**
	 * @return int
	 */
	public function y();

	/**
	 * @param Account $account
	 * @return array
	 */
	public function __toArray(Account $account);

	/**
	 * @param Account $account
	 * @return array
	 */
	public static function __toListArray(Account $account);

	/**
	 * @return Sector_Interface[]
	 */
	public static function raw();

	/**
	 * @param Account $account
	 * @param int $sectorId
	 * @param bool|null $state
	 * @return Account|bool
	 */
	public static function info(Account $account, $sectorId, $state = null);
}