<?php

class ActionFightPlunder {
	/**
	 * @param Starship $aggressor
	 * @param Starship $victim
	 * @return float
	 */
	public function apply(Starship $aggressor, Starship $victim) {
		$account = $victim->account();
		$value = $account->money()->value();
		$value = round(.1 * $value);

		$account->decrement('money', $value)->update();
		$aggressor->account()->increment('money', $value);

		// @TODO Add messages.

		return $value;
	}
}
