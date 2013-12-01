<?php

class StarshipData extends Lisbeth_Entity_Starships {
	protected $table = 'starships';

	/**
	 * @return Account
	 */
	public function owner() {
		return Lisbeth_ObjectPool::get(
			'Account',
			$this->get('ownerId')
		);
	}
}