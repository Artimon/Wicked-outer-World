<?php

class ControllerJumpGate extends ControllerAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	public function renderer($section) {
		return new RenderJumpGate();
	}
}