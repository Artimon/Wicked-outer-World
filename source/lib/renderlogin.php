<?php

class RenderLogin extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		if ($this->login()) {
			// @TODO This is ugly and you know it. ^^
			header('Location: index.php?page=profile');
			exit;
		}

		$username = i18n('username');
		$password = i18n('password');

		$html = "
<div class='floatRight profile'>
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
</div>
<div class='center'>
	<img src='./wow/img/tmp_char.png'>
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

		$_SESSION['id'] = (int)$account['id'];

		return Game::getInstance()->account();
	}
}