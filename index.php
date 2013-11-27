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
	 * @return array
	 */
	public function availableLanguages() {
		return array('de', 'en');
	}

	/**
	 * @return string
	 */
	public function acceptedLanguage() {
		$request = new Leviathan_Request();
		$language = $request->server('HTTP_ACCEPT_LANGUAGE');
		$language = substr($language, 0, 2);

		$availableLanguages = $this->availableLanguages();

		return in_array($language, $availableLanguages)
			? $language
			: 'en';
	}

	public function dispatch() {
		$session = new Leviathan_Session();

		$language = Leviathan_Request::getInstance()->get('lang');
		if ($language && in_array($language, $this->availableLanguages())) {
			$session->store('language', $language);
		}

		if (!$session->value('language')) {
			if (!$language) {
				$language = $this->acceptedLanguage();
			}

			$session->store('language', $language);
		}

		$content = $this->controller();
		echo $content->ajax()
			? $this->ajax($content)
			: $this->html($content);
	}

	/**
	 * @param Account $account
	 */
	private function updateLanguage(Account $account) {
		$session = new Leviathan_Session();

		$languageAccount = $account->value('language');
		$languageRequest = Leviathan_Request::getInstance()->both('lang');
		$languageSession = $session->value('language');
		if ($languageRequest) {
			// Language has already been validated.
			$account
				->setValue('language', $languageSession)
				->update();
		}
		elseif ($languageSession !== $languageAccount) {
			$session->store('language', $languageAccount);
		}
	}

	/**
	 * @return Content
	 */
	private function controller() {
		$content = new Content();

		$router		= Router::getInstance();
		$request	= Leviathan_Request::getInstance();
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

		$fullPage = !$content->ajax();
		$game = Game::getInstance();

		if ($fullPage && $game->isOnline()) {
			$account = $game->account();
			$this->updateLanguage($account);

			Initial::get()->pollute($account);
		}

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
			// Do not refactor, online state may have changed.
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

//		$files = glob('./wow/img/tmp_bg/*.*');
//		$fileName = $files[array_rand($files)];
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

		$leaveFeedback = i18n('leaveFeedback');

		$session = new Leviathan_Session();
		$languageUrl = '?page=' . Leviathan_Request::getInstance()->both('page'). '&amp;lang=';

		$imprint = i18n('imprint');

		$products = '';
		if (!$game->isOnline()) {
			$moreGames = i18n('moreGames');

			$battleForKyoto = i18n('battleForKyoto');

			$gameBox = "
				<ul class='gameList'>
					<li>
						<a href='http://www.schlacht-um-kyoto.de' target='_blank'>
							<img src='./wow/img/suk_logo.png' alt='{$battleForKyoto}'
								title='{$battleForKyoto}'><br>
							{$battleForKyoto}
						</a>
					</li>
				</ul>";

			$gameBox = Plugins::box(
				i18n('browsergames'),
				$gameBox
			);

			$products = "
				<div id='products'>
					<div class='content'>
						<div class='company'>
							<a href='http://www.pad-soft.de' target='_blank'>
								<span class='entypo-compass'></span>
								PadSoft Game Development by Artimus
							</a>
						</div>
						<div class='moreGames'>
							<div class='selectGames'>
								{$moreGames}
								&nbsp;
								<span class='entypo-down-open'></span>
							</div>
							<div class='gamesBoard null'>
								{$gameBox}
							</div>
						</div>
					</div>
				</div>";

			$javaScript->bind("$('.moreGames').moreGames();");
		}

		$ga = false ? "
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41010022-1', 'wicked-outer-world.com');
  ga('send', 'pageview');

</script>" : '';

		$language = $session->value('language');

		return "<!doctype html>
<html lang='{$language}' ng-app='wowApp'>
	<head>
		<title>{$title}</title>
		<meta http-equiv='content-type' content='text/html; charset=windows-1252'>

		<link rel='icon' href='./wow/img/favicon.png'>

		<link rel='stylesheet' type='text/css' href='./ext/tipTip/tipTip.css'>
		<link rel='stylesheet' type='text/css' href='./wow/src/page.css?v=1.0'>
		<link rel='stylesheet' type='text/css' href='./wow/src/jquery-ui.css'>
		<link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/trontastic/jquery-ui.css' type='text/css'>
	</head>
	<body background='{$fileName}'>
		{$products}
		<div id='contentContainer'>
			{$eventBox->toHtml()}
			<div id='topBanner'>
				<div id='languageSelector'>
					<a href='{$languageUrl}de' class='lang de' title='Deutsch'></a>
					<a href='{$languageUrl}en' class='lang en' title='English'></a>
				</div>
				{$content->regionTeaser()}
				<h1>
					<a href='?'>
						<img src='' class='null' alt='WoW'>
					</a>
				</h1>
			</div>
			<div id='contentNavi' class='top'>{$content->regionSidebar()}</div>
			<div id='contentBody' class='top'>
				{$contentBody}
			</div>
		</div>

		<div id='footer'>
			<div class='content'>
				<a href='?page=imprint'>{$imprint}</a>
			</div>
		</div>

		<script type='text/javascript' src='./wow/src/i18n/{$language}.js'></script>
		<script type='text/javascript' src='./ext/jQuery/jquery-1.8.0.min.js'></script>
		<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js'></script>
		<script type='text/javascript' src='./ext/angular/angular.min.js'></script>
		<script type='text/javascript' src='./ext/tipTip/jquery.tipTip.minified.js'></script>
		<script type='text/javascript' src='./ext/demetron/demetron.js'></script>
		<script type='text/javascript' src='./wow/src/default.js?v=1.0'></script>
		<script type='text/javascript'>{$javaScript->bindings()}</script>

<script type='text/javascript'>
reformal_wdg_domain  = 'wicked-outer-world';
reformal_wdg_mode    = 0;
reformal_wdg_title   = 'Wicked outer World';
reformal_wdg_ltitle  = '{$leaveFeedback}';
reformal_wdg_lfont   = '';
reformal_wdg_lsize   = '';
reformal_wdg_color   = '#FFA000';
reformal_wdg_bcolor  = '#516683';
reformal_wdg_tcolor  = '#FFFFFF';
reformal_wdg_align   = 'left';
reformal_wdg_waction = 0;
reformal_wdg_vcolor  = '#9FCE54';
reformal_wdg_cmline  = '#E0E0E0';
reformal_wdg_glcolor = '#105895';
reformal_wdg_tbcolor = '#FFFFFF';

reformal_wdg_bimage = '8489db229aa0a66ab6b80ebbe0bb26cd.png';

</script>

<script type='text/javascript' language='JavaScript' src='http://idea.informer.com/tab6.js?domain=wicked-outer-world'></script><noscript><a href='http://wicked-outer-world.idea.informer.com'>Wicked outer World feedback </a> <a href='http://idea.informer.com'><img src='http://widget.idea.informer.com/tmpl/images/widget_logo.jpg' /></a></noscript>

	{$ga}
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

	private function dbConnect() {
		Lisbeth_KeyGenerator::setCacheSpace(DATABASE_FOR_MYSQL);

		$database = new Lisbeth_Database();
		$database->connect(HOST_FOR_MYSQL, USER_FOR_MYSQL, PASS_FOR_MYSQL) or die('no connection');
		$database->selectDatabase(DATABASE_FOR_MYSQL) or die('no database');

		Lisbeth_Memcache::getInstance()->connect('localhost', 11211);
	}

	private function dbDisconnect() {
		$database = new Lisbeth_Database();
		$database->close();
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

JavaScript::create()->bind("$('.techInfo').techInfo();");

$dispatcher = new dispatcher();
$dispatcher->dispatch();