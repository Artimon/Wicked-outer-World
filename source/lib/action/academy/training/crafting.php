<?php

class Action_Academy_Training_Crafting extends Action_Academy_Training_Abstract {
	/**
	 * @return string
	 */
	protected function key() {
		return 'crafting';
	}

	/**
	 * @return int
	 */
	protected function skillLevel() {
		return $this->account()->craftingLevel();
	}
}