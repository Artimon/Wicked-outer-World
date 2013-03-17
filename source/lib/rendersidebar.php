<?php

/**
 * Handles sidebar creation for online and offline mode.
 */
class RenderSidebar {
	/**
	 * @return string
	 */
	public function offlineHtml() {
		$entries = array(
			array(
				'title' => i18n('login'),
				'route' => 'login'
			),
			array(
				'title' => i18n('register'),
				'route' => 'register'
			),
			array(
				'title' => i18n('pirateNews'),
				'route' => 'pirateNews'
			)
		);

		return $this->renderMenu($entries);
	}

	/**
	 * @return string
	 */
	public function onlineHtml() {
		$starbase = Game::getInstance()->account()->starbase();
		$modules = $starbase->modules();

		$entries = array(
			array(
				'title' => i18n('profile'),
				'route' => 'profile'
			),
			array(
				'title' => $starbase->name()
			)
		);

		foreach ($modules as $module) {
			$entries[] = array(
				'title' => $module->name(),
				'route' => $module->route(),
				'space' => $module->menuSpacer()
			);
		}

		$entries[] = array(
			'title' => i18n('Logout'),
			'route' => 'logout'
		);

		return $this->renderCharacter() . $this->renderMenu($entries);
	}

	/**
	 * @return string
	 */
	protected function renderCharacter() {
		$account = Game::getInstance()->account();

		$accountMoney = $account->money();
		$money = $accountMoney->short();
		$premiumCoins = $accountMoney->premiumCoins();

		$moneyName			= i18n('moneyName');
		$messagesTitle		= i18n('messages');
		$eventsTitle		= i18n('events');
		$premiumCoinsTitle	= i18n('premiumCoins');

		/*
		 * Space Pounds s£
		 * Space Pfund s£
		 */

		$html = "
<div class='floatRight'>{$money}</div>
<div>{$moneyName}</div>
<div class='clear seperator'></div>

<div class='floatRight'>-</div>
<div>{$messagesTitle}</div>
<div class='clear seperator'></div>

<div class='floatRight'>-</div>
<div>{$eventsTitle}</div>
<div class='clear seperator'></div>

<div class='floatRight'>{$premiumCoins}</div>
<div>{$premiumCoinsTitle}</div>";

		return Format::box(i18n('pilot'), $html);
	}

	/**
	 * @param array $entries
	 * @return string
	 */
	protected function renderMenu(array $entries) {
		$html = '';

		// @TODO Change to game::create()->currentRoute();
		$route = Request::getInstance()->get('page');

		$count = count($entries) - 1;
		foreach ($entries as $index => $entry) {
			$addSpace = !empty($entry['space']);

			$title = $entry['title'];
			if (isset($entry['route'])) {
				$class = array('menu');

				if ($addSpace) {
					$class[] = 'space';
				}

				if ($route === $entry['route']) {
					$class[] = 'selected';
				}

				$class = implode(' ', $class);

				$html .= "<a href='?page={$entry['route']}' class='{$class}'><span></span> {$title}</a>";
			}
			else {
				$html .= "<div class='headline menu'>{$title}</div>";
			}

			if (!$addSpace && $index < $count) {
				$html .= "<div class='seperator'></div>";
			}
		}

		return Format::box(i18n('menu'), $html);
	}
}
