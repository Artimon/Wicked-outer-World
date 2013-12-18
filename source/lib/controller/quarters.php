<?php

class Controller_Quarters extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	public function renderer($section) {
		$this->assertModule(new Starbase_Module_Quarters());

		switch ($section) {
			case 'quarter':
				$renderer = new RendererQuartersQuarter();
				break;

			case 'lounge':
				$renderer = new RendererQuartersLounge();
				break;

			default:
				$renderer = new RendererQuartersEntrance();
		}

		return $renderer->setController($this);
	}
}