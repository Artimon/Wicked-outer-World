<?php

class RenderAcademyTraining extends RenderAcademyAbstract {
	protected function commitActions() {
		$request = Leviathan_Request::getInstance();

		if (!Leviathan_Token::getInstance()->valid('token')) {
			return;
		}

		$type = $request->get('train');
		$actionAcademyTraining = $this->account()->factory()->actionAcademyTraining($type);
		$actionAcademyTraining && $actionAcademyTraining->start();
	}

	public function bodyHtml() {
		$this->commitActions();

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

		$account = $this->account();
		$accountFactory = $account->factory();
		$tacticsTraining = $accountFactory->actionAcademyTraining('tactics');
		$defenseTraining = $accountFactory->actionAcademyTraining('defense');
		$craftingTraining = $accountFactory->actionAcademyTraining('crafting');

		$disciplines = array();
		$disciplines[] = array(
			'name' => 'tactics',
			'level' => $account->tacticsLevel(),
			'current' => $account->tacticsExperience(),
			'max' => $tacticsTraining->neededExperience(),
			'hasSufficientLevel' => $tacticsTraining->hasSufficientLevel(),
			'hasStats' => $tacticsTraining->hasStats(),
			'canStart' => $tacticsTraining->canStart(),
			'url' => $trainTacticsUrl
		);
		$disciplines[] = array(
			'name' => 'defense',
			'level' => $account->defenseLevel(),
			'current' => $account->defenseExperience(),
			'max' => $defenseTraining->neededExperience(),
			'hasSufficientLevel' => $defenseTraining->hasSufficientLevel(),
			'hasStats' => $defenseTraining->hasStats(),
			'canStart' => $defenseTraining->canStart(),
			'url' => $trainDefenseUrl
		);
		$disciplines[] = array(
			'name' => 'crafting',
			'level' => $account->craftingLevel(),
			'current' => $account->craftingExperience(),
			'max' => $craftingTraining->neededExperience(),
			'hasSufficientLevel' => $craftingTraining->hasSufficientLevel(),
			'hasStats' => $craftingTraining->hasStats(),
			'canStart' => $craftingTraining->canStart(),
			'url' => $trainCraftingUrl
		);
		$disciplines = json_encode($disciplines);

		return "
<div id='academyTraining' ng-controller='AcademyTrainingCtrl' ng-init='setup({$disciplines})'>
	<h2>{{'training'|i18n}}</h2>
	<p>{{'trainingDescription'|i18n}}</p>
	{$progressBar}
	<table class='trainingOverview'>
		<colgroup>
			<col width='120'>
			<col width='150'>
			<col width='200'>
			<col>
		</colgroup>
		<tr ng-repeat='discipline in disciplines'>
			<td class='highlight'>
				{{discipline.name|i18n}}
			</td>
			<td class='smallFont variable'>
				{{discipline.level}}<br>
				<ng-status-bar current='discipline.current' max='discipline.max'>
			</td>
			<td>
				<a href='javascript:;' class='button small' ng-click='info(discipline)'>
					{{'info'|i18n}}
				</a>
				<a href='javascript:;' class='button' title='{{\"youGo\"|i18n}}'
					ng-class='{ disabled: !discipline.canStart }'
					ng-click='start(discipline)'>
					{{'train'|i18n}}
				</a>
			</td>
			<td>
				<span class='critical bold' ng-show='!discipline.hasSufficientLevel'>
					{{'moduleLevelTooLow'|i18n}}
				</span>
				<span class='critical bold' ng-show='discipline.hasSufficientLevel && !discipline.hasStats'>
					{{'youAreAllRunDown'|i18n}}
				</span>
			</td>
		</tr>
	</table>
</div>";
	}
}
