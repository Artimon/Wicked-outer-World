<?php

class RenderAccount extends RendererAbstract {
	public function commit() {
		$request = $this->request();

		if (!$request->post('confirm')) {
			return;
		}

		$this->account()->abandon();

		$session = new Leviathan_Session();

		$language = $session->value('language');
		$session
			->reset()
			->store('language', $language);

		$controller = $this->controller();
		$controller->redirect(
			$controller->route('login')
		);
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$this->commit();

		$account = $this->account();

		$headline = i18n('account');
		$accountDataEmail = i18n(
			'accountDataEmail',
			$account->value('email')
		);
		$abandonAccount = i18n('abandonAccount');
		$abandonNotice = i18n('abandonNotice');
		$confirm = i18n('confirm');
		$delete = i18n('delete');

		return "
			<div id='account'>
				<h2>{$headline}</h2>
				<p>{$accountDataEmail}</p>
				<p class='bold highlight spacer'>{$abandonAccount}</p>
				<p>{$abandonNotice}</p>
				<form action='' method='post'>
					<label class='critical'>
						<input type='checkbox' name='confirm'>
						{$confirm}
					</label>
					<input type='submit' name='delete' class='button' value='{$delete}'>
				</form>
			</div>";
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	/**
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}