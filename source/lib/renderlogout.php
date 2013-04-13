<?php

class RenderLogout extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$session = new Leviathan_Session();

		$language = $session->value('language');
		$session
			->reset()
			->store('language', $language);

		$headline = i18n('logoutHeadline');
		$description = i18n('logoutDescription');
		$footNote = i18n('logoutFootNote');

		$cookie = new Leviathan_Cookie();
		$cookie->store('user', '');

		return "
			<h2 class='error'>{$headline}</h2>
			<p>{$description}</p>
			<p class='highlight'>{$footNote}</p>";
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
