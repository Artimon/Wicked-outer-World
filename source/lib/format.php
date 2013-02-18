<?php

class Format {
	/**
	 * @TODO Add language to formatting.
	 *
	 * @static
	 * @param float $value
	 * @param int $digits
	 * @return string
	 */
	public static function number($value, $digits = 0) {
		return number_format($value, $digits, ',', '.');
	}

	/**
	 * @param int|float $value
	 * @param bool $short
	 * @return string
	 */
	public static function money($value, $short = true) {
		$result = $short
			? i18n('moneySign')
			: i18n('moneyName');

		return self::number($value) . ' ' . $result;
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

	/**
	 * @param int|float $value
	 * @param int|float $max
	 * @return string
	 */
	public static function percentageOf($value, $max) {
		$percentage = $value / $max;
		$percentage = round(100 * $percentage);
		$percentage = min(100, max(0, $percentage));

		return $percentage . '%';
	}
}