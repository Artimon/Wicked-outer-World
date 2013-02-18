<?php
/**
 * Handles js calls.
 */
class JavaScript {
	/**
	 * @var string
	 */
	private $bindings = '';

	/**
	 * @static
	 * @return JavaScript
	 */
	public static function create() {
		return Lisbeth_ObjectPool::get('JavaScript');
	}

	/**
	 * @param string $js
	 * @return JavaScript
	 */
	public function bind($js) {
		$this->bindings .= "\n{$js}\n";

		return $this;
	}

	/**
	 * @return string
	 */
	public function bindings() {
		return $this->bindings;
	}
}
