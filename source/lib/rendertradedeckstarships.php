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

		$price->buy();

		$account
			->setValue('starshipId', $item->id())
			->setValue('itemsWeaponry', '')
			->setValue('itemsAmmunition', '')
			->setValue('itemsEquipment', '')
			->setValue('itemsCargo', '')
			->setValue('itemsEngine', '')
			->update();

		EventBox::get()->success(
			i18n('shipBought')
		);
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$this->commit();

		$headline = i18n('starships');
		$attention = i18n('attention');
		$notice = i18n('buyStarshipNotice');
		$buttonText = i18n('buy');

		$account = $this->account();
		$price = $account->price();

		$html = '';

		$config = Config::getInstance()->technology();
		$config = array_keys($config->technology);
		foreach ($config as $techId) {
			$item = Technology::raw($techId);
			if (!$item->isStarship()) {
				continue;
			}

			$title = '';
			$class = 'button';
			$shopPrice = $item->shopPrice();
			$canAfford = $price->set($shopPrice)->canAfford();

			$shopPrice = Format::money($shopPrice);

			if (!$canAfford) {
				$title = i18n('youArePoor');
				$title = " title='{$title}'";
				$class .= ' disabled tipTip';
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
			<input type='submit' class='{$class}' value='{$buttonText}'{$title}>
		</form>
	</td>
</tr>";
		}

		$html = html::defaultTable($html);

		return "
			<h2>{$headline}</h2>
			<h2 class='warning'>{$attention}</h2>
			<p class='critical'>{$notice}</p>
			{$html}";
	}
}