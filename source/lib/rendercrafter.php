<?php

/**
 * Handles crafting, disassembling and blueprinting.
 */
class RenderCrafter extends RendererAbstract {

	/**
	 * @return string
	 */
	public function bodyHtml() {
		switch (Request::getInstance()->get('section')) {
			case 'craft':
				return $this->craftHtml();

			case 'disassemble':
				return $this->disassembleHtml();

			case 'fiddle':
			default:
				return $this->fiddleHtml();
		}
	}

	public function tabsHtml() {
		return $this->overviewHtml();
	}

	public function usesBox() {
		return true;
	}

	/**
	 * @return int|null
	 */
	private function fiddle() {
		if (!Leviathan_Token::getInstance()->valid('token')) {
			return null;
		}

		$request = Request::getInstance();
		$ingredients = $request->post('ingredients');
		$amounts = $request->post('amounts');

		if (empty($ingredients) || empty($amounts)) {
			return null;
		}

		if (count($ingredients) !== count($amounts)) {
			return null;
		}

		$fiddle = new Fiddle();
		$fiddle->start();

		$maxIndex = count($amounts);
		for ($i = 0; $i < $maxIndex; ++$i) {
			$fiddle->addIngredient(
				$ingredients[$i],
				$amounts[$i]
			);
		}

		return (int)$fiddle->commit(
			$this->account()->stockage()
		);
	}

	/**
	 * @return string
	 */
	private function fiddleHtml() {
		$fiddledTechId = $this->fiddle();

		$items = $this->account()->stockage()->stock()->items();

		$selectData = array(0 => i18n('empty'));
		foreach ($items as $techId => $item) {
			if ($item->isIngredient()) {
				$selectData[$techId] = "{$item->name()} ({$item->amount()})";
			}
		}

		$temp = "
<div class='ingredient'>
	".html::selectBox('ingredients[]', $selectData)."
	<p>
		<a href='javascript:;' class='jumper left'></a>
		<input type='text' class='tiny ingredientAmount' name='amounts[]' value='-'>
		<a href='javascript:;' class='jumper right'></a>
	</p>
</div>";

		$html = "<h2>".i18n('fiddlingAround')."</h2>*Look for an engineer*<br>".
			i18n('fiddleDescription');
		// Account-ID + Day formula for recipes. If already taken default text.

		if ($fiddledTechId !== null) {
			if ($fiddledTechId > 0) {
				$crafting = $this->account()->crafting();

				$techLink = html::techLink($fiddledTechId);
				if (!$crafting->hasRecipe($fiddledTechId)) {
					$message = i18n('newRecipeMessage', $techLink);
					$html .= "<p>{$message}</p>";
				}

				$crafting->addRecipe($fiddledTechId);

				$message = i18n('fiddleSuccessMessage', $techLink);
				EventBox::get()->success($message);
			}
			else {
				EventBox::get()->failure(
					i18n('fiddleFailMessage')
				);
			}
		}

		$token = Leviathan_Token::getInstance()->get();

		$html .= "
<form action='' method='post'>
	<p>
		".str_repeat($temp, 5)."
	</p>
	<input type='hidden' name='token' value='{$token}'>
	<input id='fiddleCommit' type='submit' class='button disabled' value='".i18n('tryIt')."'>
</form>
<div class='fiddlingContainer null'>
	<span class='highlight'>".i18n('fiddleFiddle')."</span>
	" . Plugins::progressBar() . "
</div>";

		$javaScript = JavaScript::create();
		$javaScript->bind("$('#fiddleCommit').fiddle();");

		return $html;
	}

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
	private function craftHtml() {
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

		return 'wanna craft something?<br>'.$html;
	}

	/**
	 * @return string
	 */
	private function disassembleHtml() {
		return 'Lemme take that apart!';
	}

	/**
	 * @return string
	 */
	private function overviewHtml() {
		$router = Router::getInstance();

		$links = array(
			"<a class='tab' href='{$router->fromRequest('fiddle')}'>".i18n('fiddle')."</a>",
			"<a class='tab' href='{$router->fromRequest('craft')}'>".i18n('craft')."</a>",
			"<a class='tab' href='{$router->fromRequest('disassemble')}'>".i18n('disassemble')."</a>"
		);

		return implode('', $links);
	}
}
