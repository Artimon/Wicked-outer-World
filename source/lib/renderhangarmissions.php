<?php

class RenderHangarMissions extends RenderHangarAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$missionId = $this->request()->get('mission');

		return $missionId
			? $this->missionActionHtml($missionId)
			: $this->missionSelectionHtml();
	}

	/**
	 * @return string
	 */
	protected function missionSelectionHtml() {
		$config = Config::getInstance()->missions();

		$startMission = i18n('startMission');
		$notEnoughEndurance = i18n('notEnoughEndurance');
		$notEnoughActionPoints = i18n('notEnoughActionPoints');
		$go = i18n('go');

		$starTrip = $this->account()->factory()->actionHangarStarTrip();
		if ($starTrip->canStart()) {
			$class = '';
			$title = $startMission;
		}
		else {
			$class = ' disabled';
			$title = $notEnoughEndurance;
		}

		$url = $this->controller()->currentRoute(
			array('section' => 'starTrip')
		);

		$html = "
<div class='center'>
	<h2>" . i18n('starTrip') . "</h2>
	<p>" . i18n('starTripDescription') . "</p>
	<a href='{$url}' title='{$title}' class='tipTip button{$class}'>{$go}</a>
</div>
<hr>";

		$mission = $this->account()->factory()->actionHangarMission();
		foreach ($config->missions as $missionId => $data) {
			$mission->load($missionId);
			if ($mission->canStart()) {
				$class = '';
				$title = $startMission;
			}
			else {
				$class = ' disabled';
				$title = $notEnoughActionPoints;
			}

			$url = $this->controller()->currentSection(
				array('mission' => $missionId)
			);

			$missionName = i18n($data['name']);


			$html .= "
<li class='mission'>
	<h2>{$missionName}</h2>
	<a href='{$url}' title='{$title}' class='tipTip button{$class}'>{$go}</a>
</li>";
		}

		return "
<ul class='list'>{$html}</ul>
<div class='clear'></div>";
	}

	/**
	 * @param int $missionId
	 * @return string
	 */
	protected function missionActionHtml($missionId) {
		$json = $this->account()->factory()->actionHangarMission()->load($missionId)->start();
		$js = "$('#missionBox').missionBox('{$json}');";

		JavaScript::create()->bind($js);

		$missionTitle = i18n('youStartAMission');

		return "
<div id='missionBox'>
	<h2>{$missionTitle}</h2>
</div>";
	}
}
