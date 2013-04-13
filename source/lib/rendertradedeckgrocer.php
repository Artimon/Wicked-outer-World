<?php

class RenderTradeDeckGrocer extends RenderTradeDeckAbstract {
	protected function commit() {
		$request = $this->request();

		$techId = (int)$request->post('techId', 0);
		if ($techId === 0) {
			return;
		}

		$account = $this->account();
		$stock = $account->stockage()->stock();
		if (!$stock->hasItem($techId)) {
			return;
		}

		$item = $stock->item($techId);
		$amount = (int)$request->post('amount', 0);
		$amount = min($amount, $item->amount());
		if ($amount <= 0) {
			return;
		}

		$sellPrice = $this->sellPrice($item);
		$sellPrice = (int)($sellPrice * ($amount / $item->stackSize()));

		$account->price()->set($sellPrice)->sell();

		$item->sub($amount);
		$stock->update();

		$message = i18n(
			'itemSold',
			$amount,
			$item->name(),
			Format::money($sellPrice)
		);
		EventBox::get()->success($message);
	}

	public function bodyHtml() {
		$this->commit();

		$headline = i18n('grocer');
		$description = i18n('grocerDescription');

		$html = '';

		$items = $this->account()->stockage()->stock()->items();
		foreach ($items as $item) {
			if (!$item->isShoppable() || $item->amount() < 1) {
				continue;
			}

			$html .= $this->itemLine($item);
		}

		$howMany = i18n('howMany');
		JavaScript::create()->bind("$('.moveItem').moveItem('{$howMany}');");

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>" .
			html::defaultTable($html);
	}

	/**
	 * @param Technology $item
	 * @return int
	 */
	public function sellPrice(Technology $item) {
		return max(1, (int)round(0.09 * $item->shopPrice()));
	}

	/**
	 * @param Technology $item
	 * @return string
	 */
	protected function itemLine(Technology $item) {
		$amount = $item->amount();
		$weight = $item->weight();

		$techId = $item->id();

		$buttonText = i18n('sell');
		$priceText = Format::money($this->sellPrice($item));
		$priceText = "<span class='highlight'>{$priceText}</span>";
		if ($item->isStackable() && $item->stackSize() > 1) {
			$priceText .= " / {$item->stackSize()}";
		}

		return "
<tr>
	<td class='top'>{$weight}t</td>
	<td>
		<span class='variable'>{$item->name()} ({$amount})</span><br>
		{$priceText}
	</td>
	<td class='top'>
		<form action='' method='post'>
			<input type='button' class='techInfo button small' value='Info' data-techId='{$techId}'>

			<input type='hidden' name='techId' value='{$techId}'>
			<input type='hidden' name='amount' value='1' class='amount'>
			<input type='hidden' name='possible' value='{$amount}' class='possible'>
			<input type='submit' class='moveItem button' value='{$buttonText}'>
		</form>
	</td>
</tr>";
	}
}