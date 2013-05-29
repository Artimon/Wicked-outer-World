<?php

abstract class ControllerAbstract implements ControllerInterface {
	/**
	 * @var bool
	 */
	private $database;

	/**
	 * @var bool
	 */
	private $ajax;

	/**
	 * @param string $route
	 * @return string
	 */
	public function route($route) {
		return '?page=' . $route;
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	public function currentRoute(array $parameters = array()) {
		$page = Leviathan_Request::getInstance()->both('page');

		if ($page) {
			$parameters = array_merge(
				array('page' => $page),
				$parameters
			);
		}

		$url = array();
		foreach ($parameters as $index => $value) {
			$url[] = "{$index}={$value}";
		}

		$url = implode('&amp;', $url);
		if ($url) {
			$url = '?' . $url;
		}

		return $url;
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	public function currentSection(array $parameters = array()) {
		$section = Leviathan_Request::getInstance()->both('section');

		if ($section) {
			$parameters['section'] = $section;
		}

		return $this->currentRoute($parameters);
	}

	/**
	 * @param $section
	 * @return string
	 */
	public function section($section) {
		return $this->currentRoute(array(
			'section' => $section
		));
	}

	/**
	 * @return Game
	 */
	public function game() {
		return Game::getInstance();
	}

	/**
	 * @return Leviathan_Request
	 */
	public function request() {
		return Lisbeth_ObjectPool::get('Leviathan_Request');
	}

	/**
	 * @param bool $connect
	 * @return ControllerAbstract
	 */
	public function setDatabase($connect) {
		$this->database = (bool)$connect;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function database() {
		return $this->database;
	}

	/**
	 * @param bool $ajax
	 * @return ControllerAbstract
	 */
	public function setAjax($ajax) {
		$this->ajax = (bool)$ajax;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function ajax() {
		return $this->ajax;
	}

	/**
	 * @return bool
	 */
	protected function assertOnline() {
		$game = Game::getInstance();
		$isOnline = $game->isOnline();
		if ($isOnline) {
			return;
		}

		$this->redirect(
			'?continue=' . $this->request()->get('page')
		);
	}

	public function redirect($url) {
		$url = html_entity_decode($url);
		header('location: ' . $url);
		exit;	// @TODO Call shutdown.
	}
}
