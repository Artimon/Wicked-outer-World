<?php

class Starships extends Lisbeth_Collection {
	protected $table = 'starships';
	protected $group = 'ownerId';
	protected $order = 'id';
	protected $entityName = 'StarshipData';

	/**
	 * @return bool
	 */
	public function hasMaximumAmount() {
		$entityIds = $this->entityIds();
		return count($entityIds) >= 3;
	}

	/**
	 * @param int $starshipId
	 * @return Starship
	 */
	public function starship($starshipId) {
		/** @var StarshipData $entity */
		$entity = $this->entity($starshipId);

		return $entity
			? Starship::create($entity->owner(), $starshipId)
			: null;
	}

	/**
	 * Important:
	 * Do not name as class name, will override constructor!
	 *
	 * @return Starship[]
	 */
	public function allStarships() {
		$starships = array();
		$entities = $this->entities();

		foreach ($entities as $entity) {
			$starships[] = $this->starship(
				$entity->id()
			);
		}

		return $starships;
	}
}