<?php
/**
 * Handles config data retrieval.
 */
class Config {
	/**
	 * @var stdClass
	 */
	private $configs;

	/**
	 * @static
	 * @return Config
	 */
	public static function getInstance() {
		/* @var Config $config */
		$config = ObjectPool::getLegacy('config');
		$config->init();

		return $config;
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
	 * @return stdClass
	 */
	public function routes() {
		if (!isset($this->configs->routes)) {
			$this->configs->routes =
				require_once 'source/configs/route_config.php';
		}

		return $this->configs;
	}
}