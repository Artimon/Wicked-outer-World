<?php

/**
 * Handles selection of items groups and item types.
 */
class techSelector extends techContainerSubclass {
	/**
	 * @var string
	 */
	const TYPE_WEAPONRY		= 'weaponry';
	const TYPE_AMMUNITION	= 'ammunition';
	const TYPE_EQUIPMENT	= 'equipment';
	const TYPE_CARGO		= 'cargo';
	const TYPE_ENGINE		= 'engine';
	const TYPE_STOCK		= 'stock';
	const TYPE_TRASH		= 'trash';
	const TYPE_APPEAR		= 'appear';
	const TYPE_FIDDLE		= 'fiddle';

	/**
	 * @static
	 * @param string $type
	 * @return string
	 */
	public static function fieldFromType($type) {
		return 'items'.ucfirst($type);
	}

	/**
	 * @var array
	 */
	public $techGroups = array();

	/**
	 * @param string $type
	 * @param bool $load
	 * @return techGroup
	 */
	public function loadItems($type, $load = true) {
		if (isset($this->techGroups[$type])) {
			return $this->techGroups[$type];
		}

		$techGroup = new techGroup($this->techContainer());
		$techGroup->setType($type);

		if ($load) {
			$sourceString = self::fieldFromType($type);
			$json = $this->techContainer()->dataSource()->value($sourceString);

			$techGroup->fromJson($json);
		}

		$this->techGroups[$type] = $techGroup;

		return $techGroup;
	}

	/**
	 * Get techGroup by name.
	 *
	 * @param	string	$name
	 * @return	techGroup
	 * @throws	InvalidArgumentException
	 */
	public function byName($name) {
		if (!method_exists($this->techContainer(), $name)) {
			$message = "Method '{$name}' unknown in ".__METHOD__;
			throw new InvalidArgumentException($message);
		}

		return $this->{$name}();
	}

	/**
	 * @return techGroup
	 */
	public function weaponry() {
		return $this->loadItems(self::TYPE_WEAPONRY);
	}

	/**
	 * @return techGroup
	 */
	public function ammunition() {
		return $this->loadItems(self::TYPE_AMMUNITION);
	}

	/**
	 * @return techGroup
	 */
	public function equipment() {
		return $this->loadItems(self::TYPE_EQUIPMENT);
	}

	/**
	 * @return techGroup
	 */
	public function cargo() {
		return $this->loadItems(self::TYPE_CARGO);
	}

	/**
	 * @return techGroup
	 */
	public function engine() {
		return $this->loadItems(self::TYPE_ENGINE);
	}

	/**
	 * @return techGroup
	 */
	public function stock() {
		return $this->loadItems(self::TYPE_STOCK);
	}

	/**
	 * @return techGroup
	 */
	public function trash() {
		return $this->loadItems(self::TYPE_TRASH, false);
	}

	/**
	 * @return techGroup
	 */
	public function appear() {
		return $this->loadItems(self::TYPE_APPEAR, false);
	}

	/**
	 * @return techGroup
	 */
	public function fiddle() {
		return $this->loadItems(self::TYPE_FIDDLE, false);
	}
}