<?php

class RenderFactoryFiddle extends RenderFactoryAbstract {
	/**
	 * @return int|null
	 */
	private function fiddle() {
		if (!Leviathan_Token::getInstance()->valid('token')) {
			return null;
		}

		$request = Leviathan_Request::getInstance();
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
	public function bodyHtml() {
		$fiddledTechId = $this->fiddle();

		$items = $this->account()->stockage()->stock()->items();

		$selectData = array(0 => i18n('empty'));
		foreach ($items as $item) {
			$techId = $item->id();
			$selectData[$techId] = "{$item->name()} ({$item->amount()})";
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

		$fiddlingAround = i18n('fiddlingAround');
		$fiddleDescription = i18n('fiddleDescription');
		$lookForAnEngineer = i18n('lookForAnEngineer');

		$html = "
			<h2>{$fiddlingAround}</h2>
			<p>
				<a href='{$this->controller()->section('engineer')}'>{$lookForAnEngineer}</a>
			</p>
			{$fiddleDescription}";
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
}