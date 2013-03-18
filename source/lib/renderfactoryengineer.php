<?php

class RenderFactoryEngineer extends RenderFactoryAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$list = array();

		$config = Config::getInstance()->technology();
		$config = array_keys($config->technology);
		foreach ($config as $techId) {
			$item = Technology::raw($techId);
			if (!$item->receiveCraftHint()) {
				continue;
			}

			$list[] = $item;
		}

		$accountId = $this->account()->id();
		$random = new Leviathan_StaticRandom($accountId);

		$index = $random->random(1, count($list)) - 1;
		$item = $list[$index];

		$list = array();

		/** @var $item Technology */
		foreach ($item->craftIngredients() as $techId => $amount) {
			$list[] = $amount . ' ' . html::techLink($techId);
		}

		$headline = i18n('engineer');
		$description = i18n('engineerDescription');
		$hint = i18n('haveYouTriedFiddle', implode(', ', $list));

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>
			<p>{$hint}</p>";
	}
}