<?php

class RenderAcademyTraining extends RenderAcademyAbstract {
	protected function commitActions() {
		$request = Leviathan_Request::getInstance();

		if (!Leviathan_Token::getInstance()->valid('token')) {
			return;
		}

		$actionAcademyTraining = $this->account()->factory()->actionAcademyTraining();
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
		$tacticsHelp = i18n('tacticsHelp');
		$defenseHelp = i18n('defenseHelp');
		$craftingHelp = i18n('craftingHelp');

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

		if ($account->factory()->actionAcademyTraining()->canStart()) {
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
		<td class='highlight'>
			{$tactics}
			<span class='infoIcon tipTip' title='{$tacticsHelp}'></span>
		</td>
		<td class='smallFont variable'>
			{$account->tacticsLevel()}<br>
			{$bars->tacticsProgress()}
		</td>
		<td>
			<a href='{$trainTacticsUrl}' class='tipTip button trainSkill{$class}' title='{$title}'>{$train}</a>
		</td>
	</tr><tr>
	<tr>
		<td class='highlight'>
			{$defense}
			<span class='infoIcon tipTip' title='{$defenseHelp}'></span>
		</td>
		<td class='smallFont variable'>
			{$account->defenseLevel()}<br>
			{$bars->defenseProgress()}
		</td>
		<td>
			<a href='{$trainDefenseUrl}' class='tipTip button trainSkill{$class}' title='{$title}''>{$train}</a>
		</td>
	</tr><tr>
	<tr>
		<td class='highlight'>
			{$crafting}
			<span class='infoIcon tipTip' title='{$craftingHelp}'></span>
		</td>
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
