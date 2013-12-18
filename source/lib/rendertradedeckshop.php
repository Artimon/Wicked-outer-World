<?php

class RenderTradeDeckShop extends RenderTradeDeckAbstract {
	protected function commit() {
		$request = $this->request();

		$techId = (int)$request->post('techId', 0);
		if ($techId === 0) {
			return;
		}

		$amount = (int)$request->post('amount', 0);
		if ($amount <= 0) {
			return;
		}

		$item = Technology::raw($techId);
		if ($item->isStarship()) {
			return;
		}

		if (!$this->canAfford($item, $amount)) {
			return;
		}

		$availableItems = $this->availableItems();
		if (!array_key_exists($techId, $availableItems)) {
			return;
		}

		$account = $this->account();
		$stock = $account->stockage()->stock();

		$loadableAmount = $stock->loadableAmount($item);
		if ($loadableAmount < $amount) {
			return;
		}

		$totalPrice = $this->totalPrice($item, $amount);
		$account->price()->set($totalPrice)->buy();

		$item->add($amount * $item->stackSize());
		$trash = $account->trashContainer()->trash();
		$trash->addItem($item);
		$trash->moveItemTo($stock, $item, $item->amount());

		$stock->update();

		$message = i18n('itemBought', $item->name());
		EventBox::get()->success($message);
	}

	/**
	 * @return Technology[]
	 */
	protected function availableItems() {
		static $availableItems = array();

		if (count($availableItems) > 0) {
			return $availableItems;
		}

		$account = $this->account();
		$tradeDeck = $account->starbase()->module(Starbase_Module_TradeDeck::KEY);

		$config = Config::getInstance()->technology();
		$config = array_keys($config->technology);
		$configCount = count($config);

		$seed = $account->id() + $account->sectorId() + round(TIME / 3600);
		$staticRandom = new Leviathan_StaticRandom($seed);

		while (count($availableItems) < 8) {
			$key = $staticRandom->random(0, $configCount - 1);
			$techId = $config[$key];

			$item = Technology::raw($techId);
			if (
				!$item->isShoppable() ||
				$item->isStarship() ||
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

		$stockage = $account->stockage();
		$stock = $stockage->stock();

		$html = '
			<colgroup>
				<col width="40">
				<col width="200">
				<col>
			</colgroup>';

		foreach ($this->availableItems() as $item) {
			$buyableAmount = $this->buyableAmount($stock, $item);
			$html .= $this->itemLine($item, $buyableAmount);
		}

		$howMany = i18n('howMany');
		JavaScript::create()->bind("$('.moveItem').moveItem('{$howMany}');");

		return "
			<h2>{{'shop'|i18n}}</h2>
			<p>{{'shopDescription'|i18n}}</p>
			<p>
				{{'yourStuff'|i18n}}:
				<span class='variable'>
					{$stockage->payload()}t / {$stockage->tonnage()}t
				</span>
			</p>" . html::defaultTable($html);
	}

	/**
	 * @param Technology $item
	 * @param int $buyableAmount
	 * @return string
	 */
	protected function itemLine(Technology $item, $buyableAmount) {
		$amountInfo = '';
		$weight = $item->weight();

		$stackSize = $item->stackSize();
		if ($stackSize > 1) {
			$amountInfo = " ({$stackSize})";
		}
		else {
			$buyableAmount = min(1, $buyableAmount);
		}

		$techId = $item->id();

		$class = 'moveItem button';
		if ($buyableAmount <= 0) {
			$class .= ' disabled';
		}

		$buttonText = i18n('buy');
		$priceText = Format::money($item->shopPrice());
		if (!$this->canAfford($item)) {
			$priceText = "<span class='critical bold'>{$priceText}</span>";
		}

		return "
<tr>
	<td class='top highlight'>{$weight}t</td>
	<td>
		<span class='variable'>{$item->name()}{$amountInfo}</span><br>
		{$priceText}
	</td>
	<td class='top'>
		<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
			<input type='button' class='techInfo button small' value='Info' data-techId='{$techId}'>

			<input type='hidden' name='techId' value='{$techId}'>
			<input type='hidden' name='amount' value='1' class='amount'>
			<input type='hidden' name='possible' value='{$buyableAmount}' class='possible'>
			<input type='submit' class='{$class}' value='{$buttonText}'>
		</form>
	</td>
</tr>";
	}

	/**
	 * @param Technology $item
	 * @param int $amount
	 * @return int
	 */
	protected function totalPrice(Technology $item, $amount = 1) {
		return ($amount * $item->shopPrice());
	}

	/**
	 * @param Technology $item
	 * @param int $amount
	 * @return bool
	 */
	protected function canAfford(Technology $item, $amount = 1) {
		$price = $this->account()->price();
		$price->set($this->totalPrice($item, $amount));
		return $price->canAfford();
	}

	/**
	 * @param techGroup $stock
	 * @param Technology $item
	 * @return int
	 */
	protected function buyableAmount(techGroup $stock, Technology $item) {
		if (!$this->canAfford($item)) {
			return 0;
		}

		$loadableAmount = $stock->loadableAmount($item);
		if ($item->isStackable()) {
			$loadableAmount /= $item->stackSize();
		}

		return $loadableAmount;
	}
}