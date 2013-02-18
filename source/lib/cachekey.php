<?php

/**
 * Handles automated generation of server-specific cache keys.
 */
class cacheKey {
	public function get($index, $key = null) {
		switch ($index) {
			case 'accounts':
				$cacheKey = 'accounts';
				break;

			case 'crafting':
				$cacheKey = 'crafting';
				break;


			default:
			 throw new Exception("Cache key -{$index}- unknown!");
		}

		return Game::getInstance()->name()."_{$cacheKey}";
	}
}