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

		$developmentHeadline = i18n('developmentHeadline');
		$developmentMessage = i18n('developmentMessage');

		$html = "
<div class='floatRight columRight'>
	<form action='' method='post'>
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
	<div class='center'>
		<img src='./wow/img/tmp_char.png'>
	</div>
</div>
<div class='columLeft'>
	<h2 class='error'>{$developmentHeadline}</h2>
	<p>{$developmentMessage}</p>
	<h2>Sonntag Mittag Update (german)</h2>
	<ul>
		<li>Bank er&ouml;ffnet!</li>
		<li>Kr&auml;mer er&ouml;ffnet!</li>
	</ul>
	<h2>Montag Mittag Update (german)</h2>
	<ul>
		<li>Neue Objekte und Schiffsmodelle.</li>
		<li>Implementation des Herstellen-Skills.</li>
		<li>Kleinere Anpassungen.</li>
	</ul>
	<h2>Samstag Morgen Update (german)</h2>
	<ul>
		<li>Raumschiff-Laden er&ouml;ffnet.</li>
		<li>Missions-Ertr&auml;ge erh&ouml;ht.</li>
		<li>Munition-ins-Lader-zur&uuml;ck-Bug behoben.</li>
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
		$request = Request::getInstance();

		$username = $request->post('username');
		$password = $request->post('password');

		if (!$username) {
			return null;
		}

		$username = mysql_real_escape_string($username);
		$sql = "
			SELECT
				`id`
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
		$session->store('id', $accountId);

		$cookie = new Leviathan_Cookie();
		$cookie->store(
			'user',
			md5($accountId . '_wow'),
			86400 * 365
		);

		return Game::getInstance()->account();
	}
}