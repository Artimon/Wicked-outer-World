<?php

class RenderFactoryEngineer extends RenderFactoryAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		/** @var $list Technology[] */
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

		$seed = date('Ymd') + $this->account()->id();
		$random = new Leviathan_StaticRandom($seed);

		$index = $random->random(1, count($list)) - 1;
		$item = $list[$index];

		$account = $this->account();
		$crafting = $account->crafting();
		$hasRecipe = $crafting->hasRecipe($item->id());
		$hasLevel = ($account->craftingLevel() >= $item->level());

		if ($hasRecipe || ! $hasLevel) {
			$hint = i18n('noFiddleHint');
		}
		else {
			$list = array();

			/** @var $item Technology */
			foreach ($item->craftIngredients() as $techId => $amount) {
				$list[] = $amount . ' ' . html::techLink($techId);
			}

			$headline = i18n('engineer');
			$description = i18n('engineerDescription');
			$hint = i18n('haveYouTriedFiddle', implode(', ', $list));
		}

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>
			<p>{$hint}</p>";
	}
}