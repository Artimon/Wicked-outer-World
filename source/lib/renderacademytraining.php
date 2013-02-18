<?php

class RenderAcademyTraining extends RenderAcademyAbstract {
	protected function commitActions() {
		$request = Leviathan_Request::getInstance();

		if (!Leviathan_Token::getInstance()->valid('token')) {
			return;
		}

		$actionAcademyTraining = $this->account()->actionAcademyTraining();
		if ($request->get('train') === 'tactics') {
			$actionAcademyTraining->startTactics();
		}

		if ($request->get('train') === 'defense') {
			$actionAcademyTraining->startDefense();
		}

		if ($request->get('train') === 'crafting') {
			$actionAcademyTraining->startCrafting();
		}
	}

	public function bodyHtml() {
		$this->commitActions();

		$training = i18n('training');
		$trainDescription = i18n('trainDescription');
		$tactics = i18n('tactics');
		$defense = i18n('defense');
		$crafting = i18n('crafting');
		$train = i18n('train');

		$account = $this->account();
		$bars = $account->bars();

		$token = Leviathan_Token::getInstance()->get();

		$trainTacticsUrl = $this->controller()->currentSection(
			array('train' => 'tactics', 'token' => $token)
		);
		$trainDefenseUrl = $this->controller()->currentSection(
			array('train' => 'defense', 'token' => $token)
		);
		$trainCraftingUrl = $this->controller()->currentSection(
			array('train' => 'crafting', 'token' => $token)
		);

		$progressBar = Plugins::progressBar('null');

		$js = "$('.train').academyTraining();";
		JavaScript::create()->bind($js);

		if ($account->actionAcademyTraining()->canStart()) {
			$class = '';
			$title = i18n('youGo');
		}
		else {
			$class = ' disabled';
			$title = i18n('cannotStartTraining');
		}

		return "
<h2>{$training}</h2>
<p>{$trainDescription}</p>
{$progressBar}
<table class='trainingOverview'>
	<colgroup>
		<col width='150'>
		<col width='150'>
		<col>
	</colgroup>
	<tr>
		<td class='highlight'>{$tactics}</td>
		<td class='smallFont variable'>
			{$account->tacticsLevel()}<br>
			{$bars->tacticsProgress()}
		</td>
		<td>
			<a href='{$trainTacticsUrl}' class='tipTip button trainSkill{$class}' title='{$title}'>{$train}</a>
		</td>
	</tr><tr>
	<tr>
		<td class='highlight'>{$defense}</td>
		<td class='smallFont variable'>
			{$account->defenseLevel()}<br>
			{$bars->defenseProgress()}
		</td>
		<td>
			<a href='{$trainDefenseUrl}' class='tipTip button trainSkill{$class}' title='{$title}''>{$train}</a>
		</td>
	</tr><tr>
	<tr>
		<td class='highlight'>{$crafting}</td>
		<td class='smallFont variable'>
			{$account->craftingLevel()}<br>
			{$bars->craftingProgress()}
		</td>
		<td>
			<a href='{$trainCraftingUrl}' class='tipTip button trainSkill{$class}' title='{$title}''>{$train}</a>
		</td>
	</tr>
</table>";
	}
}
