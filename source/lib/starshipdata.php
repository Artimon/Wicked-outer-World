<?php

class StarshipData extends Lisbeth_Entity {
	protected $table = 'starships';

	/**
	 * @return Account
	 */
	public function owner() {
		return Lisbeth_ObjectPool::get(
			'Account',
			$this->value('ownerId')
		);
	}
}