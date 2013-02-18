<?php

/**
 * Handles request data retrieval.
 */
class Request {
	/**
	 * @static
	 * @return Request
	 */
	public static function getInstance() {
		return Lisbeth_ObjectPool::get('Request');
	}

	/**
	 * Return defined get parameter.
	 *
	 * @param	string			$index
	 * @param	mixed			$default
	 * @return	string|array
	 */
	public function get($index, $default = null) {
		return $this->fromSource($_GET, $index, $default);
	}

	/**
	 * Return defined post parameter.
	 *
	 * @param	string			$index
	 * @param	mixed			$default
	 * @return	string|array
	 */
	public function post($index, $default = null) {
		return $this->fromSource($_POST, $index, $default);
	}

	/**
	 * Return defined post parameter.
	 *
	 * @param	string			$index
	 * @param	mixed			$default
	 * @return	string|array
	 */
	public function both($index, $default = null) {
		return $this->fromSource($_REQUEST, $index, $default);
	}

	/**
	 * Return defined cookie parameter.
	 *
	 * @param	string			$index
	 * @param	mixed			$default
	 * @return	string|array
	 */
	public function cookie($index, $default = null) {
		return $this->fromSource($_COOKIE, $index, $default);
	}

	protected function fromSource(&$source, $index, $default) {
		if (isset($source[$index])) {
			return $source[$index];
		}

		return $default;
	}
}