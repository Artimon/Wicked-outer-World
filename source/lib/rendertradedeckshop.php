<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pascal
 * Date: 17.03.13
 * Time: 09:30
 * To change this template use File | Settings | File Templates.
 */

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
	 * @return string
	 */
	public function bodyHtml() {
		$this->commit();

		$groups = array();

		$stockage = $this->account()->stockage();
		$stock = $stockage->stock();

		$config = Config::getInstance()->technology();
		$config = array_keys($config->technology);
		foreach ($config as $techId) {
			$item = Technology::raw($techId);
			if (!$item->isShoppable() || $item->isStarship()) {
				continue;
			}

			$type = $item->type();
			if (!array_key_exists($type, $groups)) {
				$groups[$type] = array(
					'type' => $type,
					'name' => $item->typeName(),
					'items' => array()
				);
			}

			$buyableAmount = $this->buyableAmount($stock, $item);

			$groups[$type]['items'][] = $this->itemLine($item, $buyableAmount);
		}

		usort($groups, function ($a, $b) {
			return ($a['name'] > $b['name'] ? 1 : -1);
		});

		$html = '';
		$lastType = null;
		foreach ($groups as $type => &$data) {
			if ($lastType !== $data['type']) {
				$lastType = $data['type'];

				$html .= "
<a href='javascript:;' class='accordion headline'>
	<span></span>
	{$data['name']}
</a>";
			}

			$groupHtml = implode('', $data['items']);
			$groupHtml = html::defaultTable($groupHtml);
			$html .= "<div class='null'>{$groupHtml}</div>";
		}

		$headline = i18n('shop');
		$description = i18n('shopDescription');
		$yourStuff = i18n('yourStuff');

		$howMany = i18n('howMany');
		JavaScript::create()->bind("$('.moveItem').moveItem('{$howMany}');");

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>
			<p>
				{$yourStuff}:
				<span class='variable'>
					{$stockage->payload()}t / {$stockage->tonnage()}t
				</span>
			</p>" . $html;
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
		<form action='' method='post'>
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