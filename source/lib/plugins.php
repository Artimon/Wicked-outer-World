<?php

class Plugins {
	/**
	 * @param string $class
	 * @param int $max
	 * @param int $current
	 * @return string
	 */
	public static function statusBar($class, $max, $current) {
		$max = (int)$max;
		$current = (int)$current;

		$width = 0;
		if ($current > 0) {
			$width = round(99 * ($current / $max));
		}

		return "
<div class='statusBar tipTip' title='{$current} / {$max}'>
	<div class='display {$class}' style='width: {$width}px'></div>
</div>";
	}

	/**
	 * @param string $class
	 * @return string
	 */
	public static function progressBar($class = '') {
		$class = empty($class)
			? 'progressBar'
			: 'progressBar ' . $class;

		return "
			<div class='{$class}'>
				<span></span>
			</div>";
	}

	/**
	 * @param string $head
	 * @param string $body
	 * @return string
	 */
	public static function box($head, $body) {
		return "
<div class='box'>
	<h3 class='header'>{$head}</h3>
	<div class='content'>{$body}</div>
</div>";
	}
}
