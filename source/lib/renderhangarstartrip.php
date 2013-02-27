<?php

/**
 * Handles space mission rendering.
 */
class RenderHangarStarTrip extends RendererAbstract {

	/**
	 * @return string
	 */
	public function bodyHtml() {
		return $this->starTripActionHtml();
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	public function usesBox() {
		return true;
	}

	/**
	 * @return string
	 */
	protected function starTripActionHtml() {
		$this->account()->factory()->actionHangarStarTrip()->start();

		$js = "$('#space').engine2d(init);";
		JavaScript::create()->bind($js);

		$entityLoader = new entityLoader($this->account());
		$entityLoader->initSector(0);

		return "
Ladebalken beim einsammeln (Mining Module boost).<br>
<canvas id='space' width='400' height='400'></canvas>
<div id='fps'>frames: 0</div>";
	}
}