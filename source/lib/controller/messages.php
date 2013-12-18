<?php

class Controller_Messages extends Controller_Abstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract
	 */
	public function renderer($section) {
		switch ($section) {
			case 'write':
				$renderer = new RenderMessageWrite();
				break;

			case 'sent':
				$renderer = new RenderMessagesSent();
				break;

			case 'markSeen':
				$renderer = new RenderMessageMarkSeen();
				break;

			default:
				$renderer = new RenderMessageOverview();
				break;
		}

		return $renderer->setController($this);
	}
}