<?php

class RenderBank extends RendererAbstract {
	public function accountHtml(Bank $bank) {
		$yourAccountBalance = i18n('yourAccountBalance');
		$accountBalance = Format::money($bank->value());
		$bankTransferInfo = i18n(
			'bankTransferInfo',
			Format::money($bank->transferFee())
		);

		$bankIn = i18n('bankIn');
		$bankOut = i18n('bankOut');

		return "
			<p>
				{$yourAccountBalance}:
				<span class='variable'>{$accountBalance}</span>
			</p>
			<p>{$bankTransferInfo}</p>
			<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
				<input type='text' name='amount'>
				<input type='submit' name='in' value='{$bankIn}' class='button'>
				<input type='submit' name='out' value='{$bankOut}' class='button'>
			</form>";
	}

	/**
	 * @param Bank $bank
	 * @return string
	 */
	public function noAccountHtml(Bank $bank) {
		$createAccount = i18n('createBankAccount');
		$accountInfo = i18n('bankAccountInfo');

		$create = i18n('create');

		$priceTitle = i18n('price');
		$price = Format::money(
			$bank->createAccountPrice()
		);

		if (!$bank->canAfford()) {
			$priceStyle = 'critical bold';
			$buttonClass = ' disabled';
		}
		else {
			$priceStyle = 'variable';
			$buttonClass = '';
		}

		$html = "
<p class='bold highlight'>{$createAccount}</p>
<p>{$accountInfo}</p>
<p>
	{$priceTitle}: <span class='{$priceStyle}'>{$price}</span>
</p>
<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
	<input type='submit' name='createAccount' value='{$create}' class='button{$buttonClass}'>
</form>";

		return $html;
	}

	public function commit(Bank $bank) {
		$request = $this->request();

		if ($request->post('createAccount')) {
			$bank->createAccount();
		}

		$amount = (int)$request->post('amount');
		if ($amount > 0) {
			$bankIn = $request->post('in');
			if ($bankIn) {
				$bank->in($amount);
			}

			$bankOut = $request->post('out');
			if ($bankOut) {
				$bank->out($amount);
			}
		}
	}

	public function bodyHtml() {
		$bank = $this->account()->myBank();
		$this->commit($bank);

		$headline = i18n('bankHeadline');
		$description = i18n('bankDescription');

		$html = $bank->hasAccount()
			? $this->accountHtml($bank)
			: $this->noAccountHtml($bank);

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>" . $html;
	}

	public function tabsHtml() {
		return '';
	}

	public function usesBox() {
		return true;
	}
}