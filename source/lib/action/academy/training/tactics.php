<?php

class Action_Academy_Training_Tactics extends Action_Academy_Training_Abstract {
	/**
	 * @return string
	 */
	protected function key() {
		return 'tactics';
	}

	/**
	 * @return int
	 */
	protected function skillLevel() {
		return $this->account()->tacticsLevel();
	}
}