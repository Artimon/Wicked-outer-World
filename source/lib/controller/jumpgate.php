<?php

class Controller_JumpGate extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	public function renderer($section) {
		$this->assertModule(new Starbase_Module_JumpGate());

		return new RenderJumpGate();
	}
}