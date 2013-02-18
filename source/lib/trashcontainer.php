<?php

/**
 * Handles item stockage.
 */
class trashContainer extends techContainerAbstract {
	/**
	 * @return string
	 */
	public function name() {
		return i18n('trash');
	}

	/**
	 * @return techGroup
	 */
	public function trash() {
		return $this->techSelector()->trash();
	}

	/**
	 * @param technology $item
	 * @return techGroup
	 */
	public function groupByItem(technology $item) {
		return $this->techSelector()->trash();
	}

	/**
	 * @param	string	$slotName
	 * @return	int
	 */
	public function slots($slotName) {
		return 1000;
	}

	/**
	 * @return int
	 */
	public function weight() {
		return 0;
	}

	/**
	 * @return int
	 */
	public function payload() {
		return 0;
	}

	/**
	 * @return int
	 */
	public function tonnage() {
		return 1000;
	}
}