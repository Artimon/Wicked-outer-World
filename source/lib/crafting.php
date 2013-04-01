<?php

class crafting extends Lisbeth_Entity {
	/**
	 * @var string primary key name
	 */
	protected $primary = 'accountId';

	/**
	 * @var string
	 */
	protected $table = 'crafting';

	/**
	 * @var array
	 */
	private $recipes;

	/**
	 * @return array of [*techId* => *count crafted*]
	 */
	public function recipes() {
		if ($this->recipes === null) {
			$this->recipes = (array)json_decode($this->value('recipes'), true);
		}

		return $this->recipes;
	}

	/**
	 * @param int $techId
	 * @return bool
	 */
	public function hasRecipe($techId) {
		$techId = (int)$techId;

		$recipes = $this->recipes();
		return array_key_exists($techId, $recipes);
	}

	/**
	 * @param int $techId
	 */
	public function addRecipe($techId) {
		$techId = (int)$techId;

		$technology = Technology::raw($techId);
		if (!$technology->isCraftable()) {
			return;
		}

		$recipes = $this->recipes();
		if ($this->hasRecipe($techId)) {
			++$recipes[$techId];
		} else {
			$recipes[$techId] = 1;
		}

		$this
			->setValue('recipes', json_encode($recipes))
			->update();
	}

	/**
	 * @param techGroup $stock
	 * @param int $techId
	 * @return bool
	 */
	public function canCraft(techGroup $stock, $techId) {
		$itemLevel = Technology::raw($techId)->level();
		$craftingLevel = $stock->techContainer()->account()->craftingLevel();

		if ($itemLevel > $craftingLevel) {
			return false;
		}

		return (
			$this->hasRecipe($techId) &&
			$stock->hasIngredients($techId)
		);
	}
}