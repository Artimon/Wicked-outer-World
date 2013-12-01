<?php

class crafting extends Lisbeth_Entity_Crafting {
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
	public function decodedRecipes() {
		if ($this->recipes === null) {
			$this->recipes = (array)json_decode($this->recipes(), true);
		}

		return $this->recipes;
	}

	/**
	 * @param int $techId
	 * @return bool
	 */
	public function hasRecipe($techId) {
		$techId = (int)$techId;

		$recipes = $this->decodedRecipes();
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

		$recipes = $this->decodedRecipes();
		if ($this->hasRecipe($techId)) {
			++$recipes[$techId];
		} else {
			$recipes[$techId] = 1;
		}

		$this
			->set('recipes', json_encode($recipes))
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