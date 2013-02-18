<?php

class math {
	/**
	 * @static
	 * @return math
	 */
	public static function create() {
		return ObjectPool::getLegacy('math');
	}

	/**
	 * @return float
	 */
	public function gaussFactor() {
		$selector = rand(1, 50);

		if ($selector > 20) {
			$difference = 0.05;
		}
		elseif ($selector > 5) {
			$difference = 0.15;
		}
		else {
			$difference = 0.25;
		}

		$difference *= rand(-102, 102) / 100;

		return (1 + $difference);
	}
}
