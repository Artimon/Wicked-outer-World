<?php

/**
 * Class RendererAbstract
 *
 * Well, mvc still turned out as the better solution, but it was worth a try.
 */
abstract class RendererAbstract implements RendererInterface {
	/**
	 * @var ControllerAbstract
	 */
	private $controller;

	/**
	 * @param ControllerInterface $controller
	 * @return RendererAbstract
	 */
	public function setController(ControllerInterface $controller) {
		$this->controller = $controller;

		return $this;
	}

	/**
	 * @return ControllerAbstract
	 */
	public function controller() {
		return $this->controller;
	}

	/**
	 * @return Leviathan_Request
	 */
	public function request() {
		return Leviathan_Request::getInstance();
	}

	/**
	 * @return Account|null
	 */
	public function account() {
		return Game::getInstance()->account();
	}

	/**
	 * @param array $tabs
	 * @return string
	 */
	protected function tabsFromArray(array $tabs) {
		$links = '';

		foreach ($tabs as $url => $label) {
			$links .= "<a class='tab' href='{$url}'>{$label}</a>";
		}

		return $links;
	}
}
