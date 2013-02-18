<?php

/**
 * Handles getting of database and cache objects.
 */
class dataObjectProvider {
	/**
	 * @var database
	 */
	private $database;

	/**
	 * @var memcache
	 */
	private $memcache;

	/**
	 * @var cacheKey
	 */
	private $cacheKey;

	/**
	 * @var ObjectPool
	 */
	private $objectPool;

	/**
	 * Get database instance.
	 *
	 * @return database
	 */
	public function database() {
		if (null === $this->database) {
			$this->database = new database();
		}

		return $this->database;
	}

	/**
	 * Get memcache instance.
	 *
	 * @return cache
	 */
	public function memcache() {
		if (null === $this->memcache) {
			$this->memcache = new cache();
		}

		return $this->memcache;
	}

	/**
	 * Get cacheKey instance.
	 *
	 * @return cacheKey
	 */
	public function cacheKey() {
		if (null === $this->cacheKey) {
			$this->cacheKey = new cacheKey();
		}

		return $this->cacheKey;
	}

	/**
	 * Get objectPool instance.
	 *
	 * @return ObjectPool
	 */
	public function objectPool() {
		if (null === $this->objectPool) {
			$this->objectPool = new ObjectPool();
		}

		return $this->objectPool;
	}
}