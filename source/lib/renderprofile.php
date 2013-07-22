<?php

class RenderProfile extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$section = $this->request()->get('section');

		$content = $section === 'spaceDoctor'
			? $this->spaceDoctorHtml()
			: $this->profileHtml();

		return "
<div class='floatRight columnRight'>{$content}</div>
<div class='center columnLeft'>
	<img src='./wow/img/tmp_char.png'>
</div>
<div class='clear'></div>";
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

	/**
	 * @return string
	 */
	public function profileHtml() {
		$account = $this->account();
		$bars = $account->bars();

		$level = i18n('level');
		$experience = i18n('experience');
		$shipCondition = i18n('shipCondition');
		$endurance = i18n('endurance');
		$actionPoints = i18n('actionPoints');

		$spaceDoctor = i18n('spaceDoctor');
		$startCheck = i18n('startCheck');

		$levelProgress = $account->levelProgress();

		$url = $this->controller()->currentRoute(
			array('section' => 'spaceDoctor')
		);

		$endurancePercentage = Format::percentageOf(
			$account->endurance(),
			$account->maxEndurance()
		);

		$actionPointsPercentage = Format::percentageOf(
			$account->actionPoints(),
			$account->maxActionPoints()
		);

		$class = $account->factory()->actionProfileHealthCare()->canStart()
			? ''
			: ' disabled';

		$condition = $account->starship()->condition();
		$maximum = $condition->conditionMaximum();
		$current = $condition->conditionCurrent();

		$stats = $account->stats();
		$statsData = array(
			array('label' => 'damageDealt', 'number' => Format::number($stats->inflictedDamage())),
			array('label' => 'damageTaken', 'number' => Format::number($stats->takenDamage())),
			array('label' => 'hits', 'number' => Format::number($stats->hits())),
			array('label' => 'misses', 'number' => Format::number($stats->misses())),
			array('label' => 'trainings', 'number' => Format::number($stats->trainings()))
		);
		$statsData = json_encode($statsData);

		return "
<h2>{$account->name()}</h2>
<table ng-controller='ProfileCtrl' ng-init='setup({$statsData})'>
	<colgroup>
		<col width='200'>
		<col width='120'>
	</colgroup>
	<tr>
		<td>{$level}</td>
		<td class='variable'>
			{$account->level()}
		</td>
	</tr>
	<tr>
		<td>{$experience}</td>
		<td class='smallFont critical'>
			{$account->experience()} /
			{$levelProgress->levelExperience()}
			[{$levelProgress->progress()}%]<br>
			{$bars->experienceBar()}
		</td>
	</tr>
	<tr>
		<td class='highlight'>{$shipCondition}</td>
		<td class='smallFont variable'>
			{$current} / {$maximum} [{$condition->conditionPercentage()}%]<br>
			{$bars->conditionBar()}
		</td>
	</tr>
	<tr>
		<td class='highlight'>{$endurance}</td>
		<td class='smallFont variable'>
			{$account->endurance()} / {$account->maxEndurance()}
			[{$endurancePercentage}]<br>
			{$bars->enduranceBar()}
		</td>
	</tr>
	<tr>
		<td class='highlight'>{$actionPoints}</td>
		<td class='smallFont variable'>
			{$account->actionPoints()} / {$account->maxActionPoints()}
			[{$actionPointsPercentage}]<br>
			{$bars->actionPointsBar()}
		</td>
	</tr>
	<tr ng-repeat='stat in stats'>
		<td>{{stat.label|i18n}}</td>
		<td class='variable'>{{stat.number}}</td>
	</tr>
</table>
<hr>
<div class='center'>
	<h2>{$spaceDoctor}</h2>
	<p class='center'>
		<a href='{$url}' class='button large{$class}'>{$startCheck}</a>
	</p>
</div>";
	}

	/**
	 * @return string
	 */
	public function spaceDoctorHtml() {
		$healthCare = $this->account()->factory()->actionProfileHealthCare();

		$reveal = $this->request()->get('reveal');
		if ($reveal) {
			$healthCare->start();
		}

		$html = "
<h2 class='center'>" . i18n('spaceDoctor') . "</h2>";

		if ($healthCare->canStart()) {
			$parameters = array(
				'section'	=> 'spaceDoctor',
				'reveal'	=> ''
			);
			$url = $this->controller()->currentRoute($parameters);

			$html .= "
<p>" . i18n('spaceDoctorDescription') . "
<p>
	<a href='{$url}1' class='revealPresent'>?</a>
	<a href='{$url}2' class='revealPresent'>?</a>
	<a href='{$url}3' class='revealPresent'>?</a>
</p>";
		}
		else {
			$url = $this->controller()->currentRoute();

			$html .= "
<p>" . i18n('spaceDoctorAlreadyVisited') . "</p>
<p class='center'>
	<a href='{$url}' class='button'>" . i18n('back') . "</a>
</p>";
		}

		return $html;
	}
}