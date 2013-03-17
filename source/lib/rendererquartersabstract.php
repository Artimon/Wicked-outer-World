<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pascal
 * Date: 17.03.13
 * Time: 14:20
 * To change this template use File | Settings | File Templates.
 */

abstract class RendererQuartersAbstract extends RenderTradeDeckAbstract {
	/**
	 * @return string
	 */
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('quarter') => i18n('quarter'),
			$controller->section('lounge') => i18n('lounge')
		);

		return $this->tabsFromArray($tabs);
	}

	/**
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}