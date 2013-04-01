<?php

/**
 * Handles item fiddling
 */
class Fiddle {
	/**
	 * @var array
	 */
	private $ingredients;

	/**
	 * @return Fiddle
	 */
	public function start() {
		$this->ingredients = array();

		return $this;
	}

	/**
	 * @param int $techId
	 * @param int $amount
	 * @return Fiddle
	 */
	public function addIngredient($techId, $amount) {
		$techId = (int)$techId;
		$amount = (int)$amount;

		if ($techId) {
			if (isset($this->ingredients[$techId])) {
				$this->ingredients[$techId] += $amount;
			} else {
				$this->ingredients[$techId] = $amount;
			}
		}

		return $this;
	}

	/**
	 * @param stockage $stockage
	 * @return int|null
	 */
	public function commit(stockage $stockage) {
		$level = $stockage->account()->craftingLevel();
		$stock = $stockage->stock();
		$config = Config::getInstance()->technology();

		$ingredientCount = count($this->ingredients);
		foreach ($config->technology as $techId => &$data) {
			if (!isset($data['craft'])) {
				continue;
			}

			if ($ingredientCount !== count($data['craft'])) {
				continue;
			}

			$item = Technology::raw($techId);
			if ($level < $item->level()) {
				continue;
			}

			$ingredients = $data['craft'];
			foreach ($ingredients as $ingredientId => $amount) {
				$ingredientChosen = array_key_exists($ingredientId, $this->ingredients);
				if (!$ingredientChosen) {
					continue 2;
				}

				$amount = (int)$amount;
				$correctAmount = ((int)$this->ingredients[$ingredientId] === $amount);
				if (!$correctAmount) {
					continue 2;
				}

				$ingredientAvailable = (
					$stock->hasItem($ingredientId) &&
					$stock->item($ingredientId)->amount() >= $amount
				);
				if (!$ingredientAvailable) {
					continue 2;
				}
			}

			$this->remove($stockage, $ingredients);
			$this->create($stockage, $techId);

			return $techId;
		}

		$decay = array();
		foreach ($this->ingredients as $ingredientId => $amount) {
			if (!$stock->hasItem($ingredientId)) {
				continue;
			}

			$amount = min($amount, $stock->item($ingredientId)->amount());
			$amount = (int)(.5 * $amount);
			$decayAmount = rand(0, $amount);

			$decay[$ingredientId] = $decayAmount;
		}

		$this->remove($stockage, $decay);

		return null;
	}

	/**
	 * @param stockage $stockage
	 * @param int $techId
	 */
	public function create(stockage $stockage, $techId) {
		$item = Technology::raw($techId);
		$amount = $item->stackSize();

		$fiddle = $stockage->fiddle();
		$fiddle->moveItemTo(
			$stockage->stock(),
			$fiddle->newItem($techId, $amount),
			$amount
		);
	}

	/**
	 * @param stockage $stockage
	 * @param array
	 */
	public function remove(stockage $stockage, $ingredients) {
		$stock = $stockage->stock();
		$trash = $stockage->account()->trashContainer()->trash();

		foreach ($ingredients as $techId => $amount) {
			$item = $stock->item($techId);

			$moved = $stock->moveItemTo($trash, $item, $amount);
		}
	}
}