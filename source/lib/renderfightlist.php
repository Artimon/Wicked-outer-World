<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pascal
 * Date: 17.02.13
 * Time: 22:59
 * To change this template use File | Settings | File Templates.
 */
class RenderFightList extends RendererAbstract {

	/**
	 * @return string
	 */
	public function bodyHtml() {
		return 'opponents';
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	/**
	 * Return true if a content-box shall be created.
	 *
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}