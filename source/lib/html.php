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
		$technology = technology::raw($techId);

		return "<a href='javascript:;' class='techInfo' data-techId='{$techId}'>{$technology->name()}</a>";
	}

	/**
	 * @static
	 * @param string $name
	 * @param array $data [value => label]
	 * @return string
	 */
	public static function selectBox($name, array $data) {
		$html = "<select name='{$name}'>";
		foreach ($data as $value => $label) {
			$html .= "<option value='{$value}'>{$label}</option>";
		}
		$html .= "</select>";

		return $html;
	}
}