<?php

/**
 * Page content value container object.
 */
class Content {
	/**
	 * @var string
	 */
	private $regionHead = '';

	/**
	 * @var string
	 */
	private $regionTeaser = '';

	/**
	 * @var string
	 */
	private $regionBody = '';

	/**
	 * @var string
	 */
	private $regionSidebar = '';

	/**
	 * @var string
	 */
	private $navigationTabs = '';

	/**
	 * @var bool
	 */
	private $ajax = false;

	/**
	 * @var bool
	 */
	private $renderBox = false;

	/**
	 * @param boolean $ajax
	 */
	public function setAjax($ajax)
	{
		$this->ajax = $ajax;
	}

	/**
	 * @return boolean
	 */
	public function ajax()
	{
		return $this->ajax;
	}

	/**
	 * @param string $navigationTabs
	 */
	public function setNavigationTabs($navigationTabs)
	{
		$this->navigationTabs = $navigationTabs;
	}

	/**
	 * @return string
	 */
	public function navigationTabs()
	{
		return $this->navigationTabs;
	}

	/**
	 * @param string $regionBody
	 */
	public function setRegionBody($regionBody)
	{
		$this->regionBody = $regionBody;
	}

	/**
	 * @return string
	 */
	public function regionBody()
	{
		return $this->regionBody;
	}

	/**
	 * @param string $regionHead
	 */
	public function setRegionHead($regionHead)
	{
		$this->regionHead = $regionHead;
	}

	/**
	 * @return string
	 */
	public function regionHead()
	{
		return $this->regionHead;
	}

	/**
	 * @param string $regionSidebar
	 */
	public function setRegionSidebar($regionSidebar)
	{
		$this->regionSidebar = $regionSidebar;
	}

	/**
	 * @return string
	 */
	public function regionSidebar()
	{
		return $this->regionSidebar;
	}

	/**
	 * @param string $regionTeaser
	 */
	public function setRegionTeaser($regionTeaser)
	{
		$this->regionTeaser = $regionTeaser;
	}

	/**
	 * @return string
	 */
	public function regionTeaser()
	{
		return $this->regionTeaser;
	}

	/**
	 * @param boolean $renderBox
	 */
	public function setRenderBox($renderBox)
	{
		$this->renderBox = $renderBox;
	}

	/**
	 * @return boolean
	 */
	public function renderBox()
	{
		return $this->renderBox;
	}
}