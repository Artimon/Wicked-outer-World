<?php

/**
 * Handles everything from a top point of view.
 */
class Game {
	/**
	 * @static
	 * @return Game
	 */
	public static function getInstance() {
		return Lisbeth_ObjectPool::get('Game');
	}

	/**
	 * @return Leviathan_Session
	 */
	public function session() {
		return Lisbeth_ObjectPool::get('Leviathan_Session');
	}

	/**
	 * @return bool
	 */
	public function isOnline() {
		return ($this->accountId() > 0);
	}

	/**
	 * @return int
	 */
	public function accountId() {
		return (int)$this->session()->value('id');
	}

	/**
	 * @return Account|null
	 */
	public function account() {
		if ($this->isOnline()) {
			return Lisbeth_ObjectPool::get(
				'Account',
				$this->accountId()
			);
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function name() {
		return 'Wicked outer World';
	}
}