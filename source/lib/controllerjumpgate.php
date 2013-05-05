<?php

class ControllerJumpGate extends ControllerAbstract {
	public function renderer($section) {
		return new RenderJumpGate();
	}
}