<?php

/**
 * Stub class for cache, as long as it is used.
 */
class cache {
	private static $caches = 0;
	private static $memcache;
	private static $connected = false;
	private static $cacheGets = 0;

	/**
	 * May need db for failure logging.
	 *
	 * @param	string	$host
	 * @param	int		$port
	 */
	public static function connect($host, $port) {
//		self::$memcache = new Memcache();
//		self::$connected = @self::$memcache->connect($host, $port);
	}

	/**
	 * @param	string	$key
	 * @param	mixed	$value
	 * @param	int		$expire
	 * @return	bool
	 */
	public function replace($key, $value, $expire = 3600) {
		if (false === self::$connected) {
			return false;
		}

		$expire = max(1, (int)$expire);
		return self::$memcache->replace($key, $value, false, $expire);
	}

	/**
	 * @param	string	$key
	 * @param	mixed	$value
	 * @param	int		$expire
	 * @return	bool
	 */
	public function set($key, $value, $expire = 3600) {
		if (false === self::$connected) {
			return false;
		}

		$expire = max(1, (int)$expire);
		return self::$memcache->set($key, $value, false, $expire);
	}

	/**
	 * @param	string	$key
	 * @return	mixed
	 */
	public function get($key) {
		if (false === self::$connected) {
			return false;
		}

		++self::$cacheGets;
		return self::$memcache->get($key);
	}

	/**
	 * @param	string	$key
	 * @return	bool
	 */
	public function delete($key) {
		if (false === self::$connected) {
			return false;
		}

		return self::$memcache->delete($key);
	}
}