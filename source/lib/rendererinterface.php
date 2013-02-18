<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Artimus
 * Date: 12.09.12
 * Time: 20:08
 * To change this template use File | Settings | File Templates.
 */
interface RendererInterface {
	/**
	 * @return string
	 */
	public function bodyHtml();

	/**
	 * @return string
	 */
	public function tabsHtml();

	/**
	 * Return true if a content-box shall be created.
	 *
	 * @return bool
	 */
	public function usesBox();
}
