<?php

class ControllerQuarters extends ControllerAbstract {
	public function renderer($section) {
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