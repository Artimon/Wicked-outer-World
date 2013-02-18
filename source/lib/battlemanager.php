<?php

class battleManager {
	/**
	 * @var int
	 */
	const MAX_ROUNDS = 20;

	/**
	 * @var starship
	 */
	private $attacker;

	/**
	 * @var starship
	 */
	private $defender;

	/**
	 * @param starship $attacker
	 * @param starship $defender
	 */
	public function setOpponents(
		starship $attacker,
		starship $defender
	) {
		$this->attacker = $attacker;
		$this->defender = $defender;
	}

	public function start() {
		$battleRenderer = renderBattle::create();
		$battleRenderer
			->addStarship($this->attacker)
			->addStarship($this->defender);

		$this->attacker->battleTimer()->opponent($this->defender);
		$this->defender->battleTimer()->opponent($this->attacker);

		$round = 0;
		do {
			/**
			 * Note:
			 * Status data consumes a round for its own.
			 */
			if (0 === $round % 5) {
				$battleRenderer->nextRound();
				$battleRenderer->addStatusData();
			}

			++$round;
			$battleRenderer->nextRound();

			$this->attacker->battleTimer()->nextRound(
				$this->defender
			);
			$this->defender->battleTimer()->nextRound(
				$this->attacker
			);
		} while ($round < self::MAX_ROUNDS);

		$battleRenderer->nextRound();
		$battleRenderer->addStatusData();

		$this->update($this->attacker->account());
		$this->update($this->defender->account());
	}

	/**
	 * @param Account $account
	 */
	private function update(Account $account) {
		$account->stats()->updateInflictedDamage();
		$account->update();
	}
}
