<?php

/**
 * Creation started on sunday 2011-12-11 08:48:23.
 */

ini_set('display_errors', 1);

error_reporting(E_ALL + E_STRICT + E_DEPRECATED);

define('TIME', time());


class dispatcher {
	/**
	 * @var string
	 */
	private $route = '';

	public function __construct() {
		if (isset($_GET['page'])) {
			$this->route = $_GET['page'];
		}

		// @TODO remove when real page structure is completed.
		if (empty($this->route)) {
			$this->route = 'login';
		}
	}

	/**
	 * @return string
	 */
	public function route() {
		return $this->route;
	}

	/**
	 * @return string
	 */
	public function acceptedLanguage() {
		$request = new Leviathan_Request();
		$language = $request->server('HTTP_ACCEPT_LANGUAGE');
		$language = substr($language, 0, 2);

		$availableLanguages = array('de', 'en');

		return in_array($language, $availableLanguages)
			? $language
			: 'en';
	}

	public function dispatch() {
		// @TODO refactor to session object
		$session = new Leviathan_Session();

		$acceptedLanguage = $this->acceptedLanguage();

		$language = Request::getInstance()->get('lang');
		if ($language) {
			// @TODO Validate against available languages.
			$session->store('language', $language);
		}

		if (!$session->value('language')) {
			$session->store('language', $acceptedLanguage);
		}

		$content = $this->controller();
		echo $content->ajax()
			? $this->ajax($content)
			: $this->html($content);
	}

	/**
	 * @return Content
	 */
	private function controller() {
		$content = new Content();

		$router		= Router::getInstance();
		$request	= Request::getInstance();
		$controller	= $router->controller();


		$content->setAjax(
			$controller->ajax()
		);

		$connectDatabase = $controller->database();
		if ($connectDatabase) {
			$this->dbConnect();
		}


		$section = $request->get('section', '');
		$renderer = $controller->renderer($section);

//		switch ($this->route) {
//			case 'test':
//				$starship = $account->Starship();
//
//				$battleManager = new battleManager();
//				$battleManager->setOpponents(
//					$starship,
//					ObjectPool::getLegacy('account', 2)->Starship()
//				);
//
//				$battleManager->start();
//
//				$renderer = renderBattle::create();
//				break;
//
//			case 'entities':
//				$renderer = new renderEntities($account);
//				break;
//
//				$renderer = new renderTechInfo($item);
//				break;
//		}

		$fullPage = !$content->ajax();

		if (isset($renderer)) {
			$content->setRegionHead(
				i18n($this->route)
			);

			$content->setRegionBody(
				$renderer->bodyHtml()
			);

			$content->setRenderBox(
				$renderer->usesBox()
			);

			if ($fullPage) {
				$content->setNavigationTabs(
					$renderer->tabsHtml()
				);
			}
		}

		$sidebar = new RenderSidebar();

		if ($fullPage) {
			$game = Game::getInstance();
			if ($game->isOnline()) {
				$content->setRegionSidebar(
					$sidebar->onlineHtml()
				);

				$status = new RenderStatus($game->account());
				$content->setRegionTeaser(
					$status->bodyHtml()
				);
			}
			else {
				$content->setRegionSidebar(
					$sidebar->offlineHtml()
				);
			}
		}

		if ($connectDatabase) {
			$this->dbDisconnect();
		}

		return $content;
	}

	/**
	 * @param Content $content
	 * @return string
	 */
	private function html(Content $content) {
		$game = Game::getInstance();

		$title = $game->name();
		$account = $game->account();

		if ($account) {
			$title .= " [{$account->name()}]";
		}

		$eventBox = EventBox::get();

		$javaScript = JavaScript::create();
		$javaScript->bind("$('.tipTip').tipTip();");
		$javaScript->bind($eventBox->javaScript());

		$files = glob('./wow/img/tmp_bg/*.*');
		$fileName = $files[array_rand($files)];
		$fileName = '';

		$contentBody = $content->regionBody();
		$navigationTabs = $content->navigationTabs();
		if ($navigationTabs) {
			$contentBody = "<div id='tabs'>{$navigationTabs}</div>" .
				$contentBody;
		}

		if ($content->renderBox()) {
			$contentBody = Format::box($content->regionHead(), $contentBody);
		}

		return "<!doctype html>
<html lang='de'>
	<head>
		<title>{$title}</title>
		<meta http-equiv='content-type' content='text/html; charset=windows-1252'>

		<link rel='icon' href='./wow/img/favicon.png'>

		<link rel='stylesheet' type='text/css' href='./ext/tipTip/tipTip.css'>
		<link rel='stylesheet' type='text/css' href='./wow/src/page.css'>
		<link rel='stylesheet' type='text/css' href='./wow/src/jquery-ui.css'>
		<link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/trontastic/jquery-ui.css' type='text/css'>
	</head>
	<body background='{$fileName}'>
		<div id='contentContainer'>
			{$eventBox->toHtml()}
			<div id='topBanner'>
				<div id='languageSelector'>
					<a href='index.php?lang=de' class='lang de' title='Deutsch'></a>
					<a href='index.php?lang=en' class='lang en' title='English'></a>
				</div>
				{$content->regionTeaser()}
			</div>
			<div id='contentNavi' class='top'>{$content->regionSidebar()}</div>
			<div id='contentBody' class='top'>
				{$contentBody}
			</div>
		</div>

<p class='center'>
	<a class='button' href='index.php?page=test'>Test</a>
	<a class='button' href='index.php?page=hangar'>".i18n('hangar')."</a>
	<a class='button' href='index.php?page=factory'>".i18n('factory')."</a>
	<a class='button' href='index.php?page=lounge'>".i18n('lounge')."</a>
	<a class='button' href='index.php?page=map'>".i18n('map')."</a>
	<a class='button' href='index.php?page=missions'>".i18n('missions')."</a>
	<a class='button' href='index.php?page=status'>".i18n('status')."</a>
</p>

		<script type='text/javascript' src='./ext/jQuery/jquery-1.8.0.min.js'></script>
		<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js'></script>
		<script type='text/javascript' src='./ext/tipTip/jquery.tipTip.minified.js'></script>
		<script type='text/javascript' src='./ext/demetron/demetron.js'></script>
		<script type='text/javascript' src='./wow/src/default.js'></script>
		<script type='text/javascript'>{$javaScript->bindings()}</script>
	</body>
</html>";
	}

	/**
	 * @param Content $content
	 * @return string
	 */
	private function ajax(Content $content) {
		return $content->regionBody();
	}

	/**
	 * @TODO Move to connection class.
	 */
	private function dbConnect() {
		define('HOST_FOR_MYSQL',		'localhost');
		define('USER_FOR_MYSQL',		'battleronAlpha');
		define('PASS_FOR_MYSQL',		'$Vietam1383');
		define('DATABASE_FOR_MYSQL',	'battleronAlpha');

		mysql_connect(HOST_FOR_MYSQL, USER_FOR_MYSQL, PASS_FOR_MYSQL) or die('no connection');
		mysql_select_db(DATABASE_FOR_MYSQL) or die('no database');

		cache::connect('localhost', 11211);
	}

	/**
	 * @TODO Move to connection class.
	 */
	private function dbDisconnect() {
		mysql_close();
	}
}


session_start();
//if (!isset($_SESSION['language'])) {
//	$_SESSION = array(
//		'id' => 1,
//		'language' => 'de'
//	);
//}

require_once './bootstrap.php';

require_once './source/i18n.php';
require_once './source/configs/base_config.php';
require_once './source/configs/tech_config.php';
require_once './source/configs/space_config.php';

JavaScript::create()->bind("$('.techInfo').techInfo();");

$dispatcher = new dispatcher();
$dispatcher->dispatch();