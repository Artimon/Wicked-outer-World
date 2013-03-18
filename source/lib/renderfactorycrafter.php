<?php

/**
 * Handles crafting, disassembling and blueprinting.
 */
class RenderFactoryCrafter extends RenderFactoryAbstract {
	/**
	 * @param techGroup $stock
	 * @param Technology $item
	 * @return string
	 */
	private function craftInfo(techGroup $stock, Technology $item) {
		$content = array();
		$ingredients = $item->craftIngredients();
		foreach ($ingredients as $techId => $amountNeeded) {
			$available = 0;
			if ($stock->hasItem($techId)) {
				$available = $stock->item($techId)->amount();
			}

			$name = html::techLink($techId);
			$content[] = "{$amountNeeded} / {$available} {$name}";
		}

		return implode('<br>', $content);
	}

	private function craft() {
		if (!Leviathan_Token::getInstance()->valid('token')) {
			return null;
		}

		$request = Request::getInstance();
		$techId = $request->post('craft');


		$fiddle = new Fiddle();
		$fiddle->start();

		$technology = Technology::raw($techId);
		$ingredients = $technology->craftIngredients();
		foreach ($ingredients as $techId => $amount) {
			$fiddle->addIngredient($techId, $amount);
		}

		return (int)$fiddle->commit(
			$this->account()->stockage()
		);
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$techId = $this->craft();
		if ($techId) {
			$message = i18n(
				'itemCrafted',
				html::techLink($techId)
			);

			EventBox::get()->success($message);
		}

		$craft = i18n('craft');
		$fiddleFiddle = i18n('fiddleFiddle');

		$account = $this->account();
		$stock = $account->stockage()->stock();
		$crafting = $account->crafting();
		$recipes = $crafting->recipes();

		$html = '';
		if (empty($recipes)) {
			$html .= "<p class='highlight'>" . i18n('noRecipes') . '</p>';
		}
		else {
			foreach ($recipes as $techId => $amount) {
				$technology = Technology::raw($techId);

				$available = 0;
				if ($stock->hasItem($techId)) {
					$item = $stock->item($techId);
					$available = $item->amount();
				}

				$needed = i18n('needed');

				$disabled = $crafting->canCraft($stock, $techId)
					? ''
					: ' disabled';

				$token = Leviathan_Token::getInstance()->get();
				$amount = array_sum($technology->craftIngredients());

				$html .= "
					<a href='javascript:;' class='accordion headline'>
						<span></span>
						{$technology->name()} ({$available})
					</a>
					<div class='null'>
						<p>{$needed}</p>
						<p class='variable'>
							{$this->craftInfo($stock, $technology)}
						</p>
						<form action='' method='post'>
							<input type='hidden' name='craft' value='{$techId}'>
							<input type='hidden' name='token' value='{$token}'>
							<input id='craftCommit' data-n='{$amount}' type='submit' class='button{$disabled}' value='{$craft}'>
						</form>
					</div>";
			}
		}

		$progressBar = Plugins::progressBar();

		$html = "
			<h2>{$craft}</h2>
			<div id='recipeList'>{$html}</div>
			<div class='craftingContainer null'>
				<span class='highlight'>{$fiddleFiddle}</span>
				{$progressBar}
			</div>";


		$js = "$('#craftCommit').craft();";
		JavaScript::create()->bind($js);

		return $html;
	}
}