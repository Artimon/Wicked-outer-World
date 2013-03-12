<?php

/**
 * Handles html stuff that should always be the same.
 */
class html {
	/**
	 * @static
	 * @param string $tableContentHtml
	 * @return string
	 */
	public static function defaultTable($tableContentHtml) {
		return "<table>{$tableContentHtml}</table>";
	}

	/**
	 * @static
	 * @param int $techId
	 * @return string
	 */
	public static function techLink($techId) {
		$techId = (int)$techId;
		$technology = Technology::raw($techId);

		return "<a href='javascript:;' class='techInfo' data-techId='{$techId}'>{$technology->name()}</a>";
	}

	/**
	 * @static
	 * @param string $name
	 * @param array $data [value => label]
	 * @param mixed $current
	 * @return string
	 */
	public static function selectBox($name, array $data, $current = null) {
		$html = "<select name='{$name}' class='{$name}'>";
		foreach ($data as $value => $label) {
			$selected = ($current == $value)
				? " selected='selected'"
				: '';

			$html .= "<option value='{$value}'{$selected}>{$label}</option>";
		}
		$html .= "</select>";

		return $html;
	}
}