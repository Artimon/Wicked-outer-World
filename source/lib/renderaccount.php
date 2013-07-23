<?php

class RenderAccount extends RendererAbstract {
	public function commit() {
		$request = $this->request();

		if ($request->post('changePassword')) {
			$password = $request->post('password');
			if (empty($password)) {
				EventBox::get()->failure(
					i18n('passwordForgotten')
				);

				return;
			}

			$this->account()->setValue(
				'password',
				md5($password)
			)->update();

			EventBox::get()->success(
				i18n('passwordSaved')
			);

			return;
		}

		if ($request->post('deleteAccount') && $request->post('confirm')) {
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

			return;
		}
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
		$changePassword = i18n('changePassword');
		$showIt = i18n('showIt');
		$save = i18n('save');
		$confirm = i18n('confirm');
		$delete = i18n('delete');

		$js = "
			$('#revealPassword').password({
				maskedId: 'password',
				unmaskedId: 'plainPassword'
			});";
		JavaScript::create()->bind($js);

		return "
			<div id='account'>
				<h2>{$headline}</h2>
				<p>{$accountDataEmail}</p>

				<p class='bold highlight spacer'>{$changePassword}</p>
				<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
					<table>
						<tr>
							<td>
								<input id='password' type='password' name='password' value='' autocomplete='off'>
								<input id='plainPassword' type='text' value='' autocomplete='off' class='null'>
								<label>
									<input type='checkbox' id='revealPassword'>
									{$showIt}
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type='submit' name='changePassword' value='{$save}' class='button'>
							</td>
						</tr>
					</table>
				</form>

				<p class='bold highlight spacer'>{$abandonAccount}</p>
				<p>{$abandonNotice}</p>
				<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
					<label class='critical'>
						<input type='checkbox' name='confirm'>
						{$confirm}
					</label>
					<input type='submit' name='deleteAccount' class='button' value='{$delete}'>
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