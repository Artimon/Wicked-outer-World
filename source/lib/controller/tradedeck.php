<?php

class Controller_TradeDeck extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererInterface
	 */
	public function renderer($section) {
		$this->assertModule(new Starbase_Module_TradeDeck());

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