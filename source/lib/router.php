<?php

class Router {
	const RESPONSE_AJAX		= 0;
	const RESPONSE_ONLINE	= 1;
	const RESPONSE_OFFLINE	= 2;

	const DEFAULT_ROUTE = 'test';

	/**
	 * @var array
	 */
	private $routes;

	public function __construct() {
		$this->routes = array(
			'home' => array(
				'dbConnect'	=> true,
				'response'	=> self::RESPONSE_ONLINE
			),
			'test' => array(
				// Include everything for dev.
				'dbConnect'	=> true,
				'response'	=> self::RESPONSE_ONLINE
			),
			'entities' => array(
				// Return entites as json.
				'dbConnect'	=> true,
				'response'	=> self::RESPONSE_AJAX
			),
			'techInfo' => array(
				// Return tech description html.
				'dbConnect'	=> false,
				'response'	=> self::RESPONSE_AJAX
			)
		);
	}

	/**
	 * @return string
	 */
	protected function route() {
		return (string)$this->request()->get('page', 'login');
	}

	/**
	 * @param array $route
	 * @param string $option
	 * @return bool
	 */
	protected function hasOption(array &$route, $option) {
		return array_key_exists($option, $route)
			? $route[$option]
			: false;
	}

	/**
	 * @return ControllerAbstract
	 */
	public function controller() {
		$route = $this->route();

		$routes = Config::getInstance()->routes();
		$routes = $routes->routes;

		$route = array_key_exists($route, $routes)
			? $routes[$route]
			: $routes['default'];

		$database = $this->hasOption($route, 'database');
		$ajax = $this->hasOption($route, 'ajax');

		/** @var $controller ControllerAbstract */
		$controller = $route['controller'];
		$controller = new $controller();
		$controller
			->setDatabase($database)
			->setAjax($ajax);

		return $controller;
	}

	/**
	 * @static
	 * @return Router
	 */
	public static function getInstance() {
		return Lisbeth_ObjectPool::get('Router');
	}

	/**
	 * @deprecated Change structure.
	 * @param string $route
	 * @return string
	 */
//	public function route($route) {
//		if (!isset($this->routes[$route])) {
//			$route = self::DEFAULT_ROUTE;
//		}
//
//		return $route;
//	}

	/**
	 * @deprecated Change structure.
	 * @param string $route
	 * @return bool
	 */
	public function dbConnect($route) {
		$route = $this->route($route);
		return $this->routes[$route]['dbConnect'];
	}

	/**
	 * @deprecated Change structure.
	 * @param string $route
	 * @return int
	 */
	public function response($route) {
		$route = $this->route($route);
		return $this->routes[$route]['response'];
	}

	/**
	 * @param string $response
	 * @return bool
	 */
	public function isAjax($response) {
		return (self::RESPONSE_AJAX === $response);
	}

	/**
	 * @deprecated Change structure.
	 * @param string $response
	 * @return bool
	 */
	public function isOnline($response) {
		return (self::RESPONSE_ONLINE === $response);
	}

	/**
	 * @deprecated Change structure.
	 * @param string $response
	 * @return bool
	 */
	public function isOffline($response) {
		return (self::RESPONSE_OFFLINE === $response);
	}

	/**
	 * @return Leviathan_Request
	 */
	public function request() {
		return Lisbeth_ObjectPool::get('Leviathan_Request');
	}

	/**
	 * @deprecated Change structure.
	 * @param string $section
	 * @return string
	 */
	public function fromRequest($section = null) {
		$request = $this->request();
		$page = $request->get('page');

		$link = 'index.php';

		if ($page || $section) {
			$link .= '?page='.$page;

			if ($section) {
				$link .= '&amp;section='.$section;
			}
		}

		return $link;
	}
}
