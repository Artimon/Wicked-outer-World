<?php

class ControllerTradeDeck extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RendererInterface
	 */
	public function renderer($section) {
		switch ($section) {
			case 'shop':
				$renderer = new RenderTradeDeckShop();
				break;

			case 'grocer':
				$renderer = new RenderTradeDeckGrocer();
				break;

			case 'starships':
				$renderer = new RenderTradeDeckStarships();
				break;

			case 'airlock':
				$renderer = new RenderTradeDeckAirlock();
				break;

			default:
				$renderer = new RenderTradeDeckEntrance();
				break;
		}

		return $renderer->setController($this);
	}
}