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

		$someStatistics = i18n('someStatistics');
		$damageDealt = i18n('damageDealt');
		$damageTaken = i18n('damageTaken');
		$hits = i18n('hits');
		$misses = i18n('misses');

		$stats = $account->stats();
		$amountDamageDealt = Format::number($stats->inflictedDamage());
		$amountDamageTaken = Format::number($stats->takenDamage());
		$amountHits = Format::number($stats->hits());
		$amountMisses = Format::number($stats->misses());

		return "
			<div id='account'>
				<h2>{$headline}</h2>
				<p>{$accountDataEmail}</p>
				<p class='bold highlight spacer'>{$someStatistics}</p>
				<table>
					<tr>
						<td>{$damageDealt}:</td>
						<td class='variable right'>{$amountDamageDealt}</td>
					</tr>
					<tr>
						<td>{$damageTaken}:</td>
						<td class='variable right'>{$amountDamageTaken}</td>
					</tr>
					<tr>
						<td>{$hits}:</td>
						<td class='variable right'>{$amountHits}</td>
					</tr>
					<tr>
						<td>{$misses}:</td>
						<td class='variable right'>{$amountMisses}</td>
					</tr>
				</table>
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