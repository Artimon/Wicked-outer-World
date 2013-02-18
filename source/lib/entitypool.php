<?php

/**
 * Object pool shorthand.
 */
class entityPool {
	/**
	 * @param int $starbaseId
	 * @return Starbase
	 */
	public static function starbase($starbaseId) {
		return ObjectPool::getLegacy('Starbase', $starbaseId);
	}
}
