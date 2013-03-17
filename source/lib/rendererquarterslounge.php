<?php

class RendererQuartersLounge extends RendererQuartersAbstract {
	const REST_CURE_PRICE = 150;

	protected function commit() {
		$request = $this->request();

		if (!$request->post('restCure')) {
			return;
		}

		$account = $this->account();
		$price = $account->price()->set(self::REST_CURE_PRICE);
		if (!$price->canAfford()) {
			return;
		}

		$price->buy();
		$account
			->incrementEndurance(10)
			->incrementActionPoints(4)
			->update();

		$message = i18n('youFeelBetter');
		EventBox::get()->success($message);
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$this->commit();

		$headline = i18n('lounge');
		$description = i18n('loungeDescription');

		$restCureHeadline = i18n('restCureHeadline');
		$restCureDescription = i18n('restCureDescription');

		$price = $this->account()->price();
		$buttonClass = 'button';

		if ($price->set(self::REST_CURE_PRICE)->canAfford()) {
			$priceStyle = 'variable';
		}
		else {
			$priceStyle = 'critical bold';
			$buttonClass .= ' disabled';
		}

		$priceLabel = i18n('price');
		$priceText = Format::money(self::REST_CURE_PRICE);
		$priceText = "<span class='{$priceStyle}'>{$priceText}</span>";

		$begin = i18n('startCourse');

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>
			<p class='bold highlight'>{$restCureHeadline}</p>
			<p>{$restCureDescription}</p>
			<p>
				{$priceLabel}: {$priceText}
			</p>
			<form action='' method='post'>
				<input type='submit' name='restCure' value='{$begin}' class='{$buttonClass}'>
			</form>";
	}
}