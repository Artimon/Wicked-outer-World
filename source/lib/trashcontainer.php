<?php

/**
 * Handles item stockage.
 */
class trashContainer extends TechContainerAbstract {
	/**
	 * @return Account|Lisbeth_Entity
	 */
	public function dataSource() {
		return $this->account();
	}

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
	 * @param Technology $item
	 * @return techGroup
	 */
	public function groupByItem(Technology $item) {
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