<?php

class RenderRegister extends RendererAbstract {
	/**
	 * @return array
	 */
	protected function formValues() {
		$request = $this->request();

		return array(
			'name' => $request->post('name', ''),
			'password' => $request->post('password', ''),
			'email' => $request->post('email', ''),
			'url' => $request->post('url'),
			'starship' => $request->post('starship')
		);
	}

	/**
	 * @param string $name
	 * @param string $password
	 * @param string $to
	 */
	protected function welcomeMail($name, $password, $to) {
		$gameName = Game::getInstance()->name();
		$subject = i18n('accountData', $gameName);

		$message = i18n(
			'welcomeMail',
			$gameName,
			$name,
			$password,
			$gameName,
			$gameName
		);

		mail(
			$to,
			$subject,
			$message,
			"From: registration@wicked-outer-world.com"
		);
	}

	protected function check() {
		$request = $this->request();
		if (!$request->post('register')) {
			return array();
		}

		$values = $this->formValues();

		$register = new Register();
		$invalid = $register->commit(
			$values['name'],
			$values['password'],
			$values['email'],
			$values['url'],
			$values['starship']
		);

		if (empty($invalid)) {
			$this->welcomeMail(
				$values['name'],
				$values['password'],
				$values['email']
			);

			$this->controller()->redirect(
				$this->controller()->route('profile')
			);
		}

		return $invalid;
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$invalid = $this->check();

		$register = i18n('register');
		$registerIntro = i18n('registerIntro');
		$coolName = i18n('coolName');
		$nameTip = i18n('nameTip');
		$crazyPassword = i18n('crazyPassword');
		$showIt = i18n('showIt');
		$email = i18n('email');
		$leaveEmpty = i18n('leaveEmpty');
		$yourShip = i18n('yourShip');
		$go = i18n('go');
		$infoTitle = i18n('wtfIsThis');

		$values = $this->formValues();

		$data = array();
		$ids = Register::startupStarshipIds();
		foreach ($ids as $id) {
			$item = Technology::raw($id);
			$data[$id] = $item->name();
		}

		$select = html::selectBox('starship', $data, $values['starship']);
		$techId = reset($ids);

		$js = "
			$('.starship').change(function () {
				var techId = $(this).val();

				$('.techInfo').attr('data-techId', techId);
			});
			$('#revealPassword').password({
				maskedId: 'password',
				unmaskedId: 'plainPassword'
			});";
		JavaScript::create()->bind($js);

		$nameClass = array_key_exists('name', $invalid)
			? " class='error tipTip'"
			: " class='tipTip'";

		if (array_key_exists('password', $invalid)) {
			$passwordClass = " class='error'";
			$plainPasswordClass = " class='error null'";
		}
		else {
			$passwordClass = '';
			$plainPasswordClass = " class='null'";
		}

		$emailClass = array_key_exists('email', $invalid)
			? " class='error'"
			: '';

		$errorMessage = (array_key_exists('name', $invalid))
			? "<p class='critical'>{$invalid['name']}</p>"
			: '';

		return "
<div id='register'>
	<h2>{$register}</h2>
	<p>{$registerIntro}</p>
	{$errorMessage}
	<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
		<table>
			<colgroup>
				<col width='160'>
				<col>
				<col>
			</colgroup>
			<tr>
				<td class='highlight'>{$coolName}</td>
				<td>
					<input type='text' name='name' maxlength='15' value='{$values['name']}' title='{$nameTip}' autocomplete='off'{$nameClass}>
				</td>
			</tr>
			<tr>
				<td class='highlight'>{$crazyPassword}</td>
				<td>
					<input id='password' type='password' name='password' value='{$values['password']}' autocomplete='off'{$passwordClass}>
					<input id='plainPassword' type='text' value='' autocomplete='off'{$plainPasswordClass}>
					<label>
						<input type='checkbox' id='revealPassword'>
						{$showIt}
					</label>
				</td>
			</tr>
			<tr>
				<td class='highlight'>{$email}</td>
				<td>
					<input type='text' name='email' value='{$values['email']}' autocomplete='off'{$emailClass}>
				</td>
			</tr>
			<tr class='null'>
				<td>{$leaveEmpty}</td>
				<td>
					<input type='text' name='url'>
				</td>
			</tr>
			<tr>
				<td class='variable'>{$yourShip}</td>
				<td>{$select}</td>
				<td>
					<div class='techInfo infoIcon tipTip' data-techId='{$techId}' title='{$infoTitle}'></div>
				</td>
			</tr>
			<tr>
				<td colspan='2' class='right'>
					<input type='submit' name='register' value='{$go}' class='button'>
				</td>
			</tr>
		</table>
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
