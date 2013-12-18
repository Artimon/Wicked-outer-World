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
				'title' => "{{'{$starbase->name()}'|i18n}}"
			)
		);

		foreach ($modules as $module) {
			$title = "{{'{$module->name()}'|i18n}}";
			$level = $module->level();
			if ($level > 0) {
				$title .= " <span class='level variable'>({$level})</span>";
			}

			$entries[] = array(
				'title' => $title,
				'route' => $module->route(),
				'space' => $module->menuSpacer()
			);
		}

		$entries[] = array(
			'title' => i18n('ranking'),
			'route' => 'ranking',
			'space' => true
		);

		$entries[] = array(
			'title' => i18n('account'),
			'route' => 'account',
			'space' => true
		);

		$entries[] = array(
			'title' => i18n('logout'),
			'route' => 'logout'
		);

		return $this->renderCharacter() . $this->renderMenu($entries);
	}

	/**
	 * @return string
	 */
	protected function renderCharacter() {
		$account = Game::getInstance()->account();

		$accountMoney = $account->myMoney();
		$money = $accountMoney->short();
		$premiumCoins = $accountMoney->premiumCoins();

		$moneyName			= i18n('moneyName');
		$messagesTitle		= i18n('messages');
		$eventsTitle		= i18n('events');
		$premiumCoinsTitle	= i18n('premiumCoins');

		$messages = new MessagesReceived(
			$account->id()
		);
		$messageCount = count(
			$messages->entityIds()
		);

		if ($messageCount === 0) {
			$messageCount = '-';
		}

		/*
		 * Space Pounds s�
		 * Space Pfund s�
		 */

		$html = "
<div class='floatRight money'>{$money}</div>
<div>{$moneyName}</div>
<div class='clear seperator'></div>

<div class='floatRight'>{$messageCount}</div>
<div>
	<a href='?page=messages'>{$messagesTitle}</a>
</div>
<div class='clear seperator'></div>

<!--<div class='floatRight'>-</div>-->
<!--<div>{$eventsTitle}</div>-->
<!--<div class='clear seperator'></div>-->

<div class='floatRight premiumCoins'>{$premiumCoins}</div>
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
		$route = Leviathan_Request::getInstance()->get('page');

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
