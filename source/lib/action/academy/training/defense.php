<?php

class Action_Academy_Training_Defense extends Action_Academy_Training_Abstract {
	/**
	 * @return string
	 */
	protected function key() {
		return 'defense';
	}

	/**
	 * @return int
	 */
	protected function skillLevel() {
		return $this->account()->defenseLevel();
	}
}