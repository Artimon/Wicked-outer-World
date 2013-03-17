<?php

class RenderTradeDeckAirlock extends RenderTradeDeckAbstract {
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

		$stock = $this->account()->stockage()->stock();
		if (!$stock->hasItem($techId)) {
			return;
		}

		$item = $stock->item($techId);
		$amount = $stock->moveItemTo(
			$this->account()->trashContainer()->trash(),
			$item,
			$amount
		);
		$stock->update();

		$message = i18n(
			'itemsDepolluted',
			Format::number($amount),
			$item->name()
		);
		EventBox::get()->success($message);
	}

	public function bodyHtml() {
		$this->commit();

		$headline = i18n('airlock');
		$description = i18n('airlockDescription');
		$yourStuff = i18n('yourStuff');
		$stock = i18n('stock');

		$account = $this->account();
		$stockage = $account->stockage();

		$itemList = Plugins::itemList(
			$account->trashContainer(),
			$stockage->stock(),
			i18n('depollute'),
			false
		);
		$itemList = html::defaultTable($itemList);

		$howMany = i18n('howMany');
		JavaScript::create()->bind("$('.moveItem').moveItem('{$howMany}');");

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>
			<p>
				<span class='headline'>{$yourStuff}</span><br>
				<span class='highlight'>
					{$stock}
					({$stockage->payload()}t / {$stockage->tonnage()}t)
				</span>
			</p>
			{$itemList}";
	}
}