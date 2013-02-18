<?php

/**
 * Basic constructor and functions for account subclasses.
 */
abstract class AccountSubclass {
	/**
	 * @var Account
	 */
	private $account;

	/**
	 * @param Account $account
	 */
	public function __construct(Account $account) {
		$this->account = $account;
	}

	/**
	 * @return Account
	 */
	public function account() {
		return $this->account;
	}

	/**
	 * @param Account $account
	 */
	public function setAccount(Account $account) {
		$this->account = $account;
	}
}