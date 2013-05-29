<?php

class RenderLogin extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		if ($this->login()) {
			$this->controller()->redirect(
				$this->controller()->route('profile')
			);
		}

		$username = i18n('username');
		$password = i18n('password');

		$headline = Game::getInstance()->name();
		$developmentMessage = i18n('developmentMessage');

		$html = "
<div class='floatRight columnRight'>
	<form action='' method='post' class='floatRight'>
		<table>
			<tr>
				<td>{$username}</td>
				<td>
					<input name='username' type='text'>
				</td>
			</tr><tr>
				<td>{$password}</td>
				<td>
					<input name='password' type='password'>
				</td>
			</tr><tr>
				<td>&nbsp;</td>
				<td class='right'>
					<input name='login' value='login' type='submit' class='button important'>
				</td>
			</tr>
		</table>
	</form>
	<div class='clear'></div>
	<p class='center'>
		<img src='./wow/img/tmp_char.png'>
	</p>
</div>
<div class='columnLeft'>
	<h2>{$headline}</h2>
	<p>{$developmentMessage}</p>
	<hr>
	<p class='headline bold'>News:</p>
	<ul>
		<li class='highlight'>Message System introduced.</li>
	</ul>
</div>
<div class='clear'></div>";;

		return $html;
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	public function usesBox() {
		return true;
	}

	/**
	 * @return Account|null
	 */
	private function login() {
		$request = Leviathan_Request::getInstance();

		$username = $request->post('username');
		$password = $request->post('password');

		if (!$username) {
			return null;
		}

		$username = mysql_real_escape_string($username);
		$sql = "
			SELECT
				`id`,
				`password`,
				`language`
			FROM
				`accounts`
			WHERE
				`name` = '{$username}' AND
				`password` = MD5('{$password}')
			LIMIT 1;";

		$database = new database();	// @TODO Replace with Lisbeth_Database
		$database->query($sql);

		$account = $database->fetch();
		$database->freeResult();

		if (!$account) {
			return null;
		}

		$accountId = (int)$account['id'];

		$session = new Leviathan_Session();
		$session
			->store('id', $accountId)
			->store('language', $account['language']);

		$cookie = new Leviathan_Cookie();
		$cookie->store(
			'user',
			md5($accountId . $account['password']),
			86400 * 365
		);

		return Game::getInstance()->account();
	}
}