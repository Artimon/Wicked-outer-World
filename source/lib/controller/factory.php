<?php

class Controller_Factory extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RenderFactoryCrafter|RendererInterface
	 */
	public function renderer($section) {
		$this->assertModule(new Starbase_Module_Factory());

		switch ($section) {
			case 'craft':
				$renderer = new RenderFactoryCrafter();
				break;

			case 'disassemble':
				$renderer = new RenderFactoryDisassemble();
				break;

			case 'engineer':
				$renderer = new RenderFactoryEngineer();
				break;

			default:
				$renderer = new RenderFactoryFiddle();
				break;
		}

		return $renderer->setController($this);
	}
}