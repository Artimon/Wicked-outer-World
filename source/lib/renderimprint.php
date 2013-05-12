<?php

class RenderImprint extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$imprint = i18n('imprint');
		$address = i18n('address');
		$country = i18n('country');
		$phone = i18n('phone');
		$contact = i18n('contact');

		JavaScript::create()->bind("jQuery('.contactMail').mail();");

		return "
			<h2>{$imprint}</h2>
			<p class='headline'>{$address}</p>
			<p>
				Pascal Dittrich - PAD-Soft<br>
				Liesel-Bach-Str. 32<br>
				71034 B&ouml;blingen ({$country})
			</p>
			<hr>
			<p>
				{$phone}
			</p>
			<hr>
			<p>
				<a href='javascript:;' class='contactMail'>{$contact}</a>
			</p>";
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