<?php

class ActionFightPlunder {
	/**
	 * @param Starship $aggressor
	 * @param Starship $victim
	 */
	public function commit(Starship $aggressor, Starship $victim) {
		$account = $victim->account();
		$value = $account->money()->value();
		$value = round(.1 * $value);

		$account->decrement('money', $value)->update();
		$aggressor->account()->increment('money', $value)->update();

		// @TODO Add messages.

		return $value;
	}
}
