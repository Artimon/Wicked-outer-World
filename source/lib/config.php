<?php
/**
 * Handles config data retrieval.
 */
class Config {
	/**
	 * @var Config
	 */
	private static $instance;

	/**
	 * @var stdClass
	 */
	private $configs;

	/**
	 * @static
	 * @return Config
	 */
	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * @return stdClass
	 */
	public function init() {
		if ($this->configs === null) {
			$this->configs = new stdClass();
		}

		return $this->configs;
	}

	/**
	 * @return stdClass
	 */
	public function technology() {
		if (!isset($this->configs->technology)) {
			global $technology;
			$this->configs->technology = &$technology;
		}

		return $this->configs;
	}

	/**
	 * @return stdClass
	 */
	public function languages() {
		if (!isset($this->configs->languages)) {
			global $languages;
			$this->configs->languages = &$languages;
		}

		return $this->configs;
	}

	/**
	 * @return stdClass
	 */
	public function missions() {
		if (!isset($this->configs->missions)) {
			$this->configs->missions =
				require_once 'source/configs/mission_config.php';
		}

		return $this->configs;
	}

	/**
	 * @param array $routes
	 * @return stdClass
	 */
	public function routes(array $routes = null) {
		if ($routes) {
			$this->configs->routes = $routes;
		}

		return $this->configs;
	}
}