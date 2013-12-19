<?php

class RenderTradeDeckStarships extends RenderTradeDeckAbstract {
	public function commit() {
		$request = $this->request();

		$techId = $request->post('techId');
		if (!$techId) {
			return;
		}

		$item = Technology::raw($techId);
		if (!$item->isStarship()) {
			return;
		}

		$account = $this->account();
		$price = $account->price()->set($item->shopPrice());
		if (!$price->canAfford()) {
			EventBox::get()->failure(
				i18n('youArePoor')
			);

			return;
		}

		$availableItems = $this->availableStarships();
		if (!array_key_exists($techId, $availableItems)) {
			return;
		}

		$price->buy();
		$account->update();

		Starship::createEntity($account, $techId);

		EventBox::get()->success(
			i18n('shipBought')
		);
	}

	/**
	 * @return Technology[]
	 */
	protected function availableStarships() {
		static $availableItems = array();

		if (count($availableItems) > 0) {
			return $availableItems;
		}

		$account = $this->account();
		$tradeDeck = $account->starbase()->module(Starbase_Module_TradeDeck::KEY);

		$config = Config::getInstance()->technology();
		$config = array_keys($config->technology);
		$configCount = count($config);

		$time = TIME + 21600;
		$seed = $account->id() + $account->sectorId() + round($time / 43200);
		$staticRandom = new Leviathan_StaticRandom($seed);

		while (count($availableItems) < 4) {
			$key = $staticRandom->random(0, $configCount - 1);
			$techId = $config[$key];

			$item = Technology::raw($techId);
			if (
				!$item->isStarship() ||
				$item->level() > $tradeDeck->level() ||
				array_key_exists($techId, $availableItems)
			) {
				continue;
			}

			$availableItems[$techId] = $item;
		}

		return $availableItems;
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$this->commit();

		$account = $this->account();
		$price = $account->price();

		$hasMaximumStarships = $account->starships()->hasMaximumAmount();

		$html = '';
		foreach ($this->availableStarships() as $techId => $item) {
			$title = '';
			$class = 'button';
			$shopPrice = $item->shopPrice();
			$canAfford = $price->set($shopPrice)->canAfford();

			$shopPrice = Format::money($shopPrice);

			if ($hasMaximumStarships) {
				$class .= ' disabled';
			}

			if (!$canAfford) {
				if (!$hasMaximumStarships) {
					$title = " title='{{\"youArePoor\"|i18n}}'";
					$class .= ' disabled tipTip';
				}

				$shopPrice = "<span class='critical bold'>{$shopPrice}</span>";
			}

			$html .= "
<tr>
	<td class='highlight top'>{$item->weight()}t</td>
	<td class='top'>
		<span class='variable'>{$item->name()}</span><br>
		{$shopPrice}
	</td>
	<td class='top'>
		<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
			<input type='button' class='techInfo button small' value='Info' data-techId='{$techId}'>

			<input type='hidden' name='techId' value='{$techId}'>
			<input type='submit' class='{$class}' value='{{\"buy\"|i18n}}'{$title}>
		</form>
	</td>
</tr>";
		}

		$html = html::defaultTable($html);

		if ($hasMaximumStarships) {
			$html = "
				<h2 class='warning'>{{'attention'|i18n}}</h2>
				<p class='critical'>{{'buyStarshipNotice'|i18n}}</p>
				{$html}";
		}

		return "
			<h2>{{'starships'|i18n}}</h2>
			<p>
				{{'starshipsDescription'|i18n}}<br>
				{{'newShipNotice'|i18n}}
			</p>
			{$html}";
	}
}