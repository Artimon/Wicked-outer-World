<?php

class RenderSkirmishOpponents extends RendererAbstract {

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$number = i18n('number');
		$pilot = i18n('pilot');
		$experience = i18n('experience');

		$list = "
			<colgroup>
				<col width='70'>
				<col width='200'>
			</colgroup>
			<tr>
				<th>{$number}</th>
				<th>{$pilot}</th>
				<th>{$experience}</th>
			</tr>";

		$account = $this->account();
		$accountId = $account->id();


		$fight = new ActionFight($account);
		$canStart = $fight->setAggressor($account->starship())->canStart();

		$skirmishOpponents = $account->factory()->actionSkirmishOpponents();

		$closeOpponents = $skirmishOpponents->closeOpponents();
		foreach ($closeOpponents as $index => $opponentData) {
			$number = ++$index;
			$id = (int)$opponentData['id'];
			$name = $opponentData['name'];
			$experience = $opponentData['experience'];
			$experience = format::number($experience);

			$class = '';
			if ($id === $accountId) {
				$class = " class='push'";
			}
			elseif ($canStart) {
				$showHim = i18n('showHim');
				$url = $this->controller()->currentSection(
					array('section' => 'fight', 'attack' => $id)
				);

				$name = "<a href='{$url}' title='{$showHim}' class='tipTip action'>{$name}</a>";
			}
			else {
				$notEnoughActionPoints = i18n('notEnoughActionPoints');
				$name = "<span title='{$notEnoughActionPoints}' class='critical tipTip'>{$name}</span>";
			}

			$list .= "
				<tr{$class}>
					<td>{$number}</td>
					<td>{$name}</td>
					<td class='right'>{$experience}</td>
				</tr>";
		}

		$headline = i18n('pirateBay');
		$description = i18n('pirateBayDescription');
		$list = html::defaultTable($list);
		$list = plugins::box(
			i18n('badBoys'),
			$list
		);

		$noWeaponsInfo = '';
		if ($account->starship()->weaponry()->isEmpty()) {
			$noWeaponsInfo = i18n('noWeaponsInfo');
			$noWeaponsInfo = "<h2 class='error'>{$noWeaponsInfo}</h2>";
		}

		return "
			<h2>{$headline}</h2>
			<div id='skirmish'>
				<div class='column'>{$description}{$noWeaponsInfo}</div>
				<div class='column'>
					{$list}
				</div>
			</div>";
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	/**
	 * Return true if a content-box shall be created.
	 *
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}