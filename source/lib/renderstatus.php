<?php

/**
 * Renders the user's status bar (hits, endurance, action points...).
 */
class RenderStatus extends AccountSubclass implements RendererInterface {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$account = $this->account();
		if (!$account->valid()) {
			return '';
		}

		$shipCondition = i18n('shipCondition');
		$endurance = i18n('endurance');
		$actionPoints = i18n('actionPoints');
		$currently = i18n('currently');

		$bars = $account->bars();

		return "
<div id='status'>
	<table>
		<tr>
			<td class='bottom'>
				<span class='entypo-tools icon'></span>
			</td>
			<td>
				{$shipCondition}<br>
				{$bars->conditionBar()}
			</td>
		</tr><tr>
			<td class='bottom'>
				<span class='entypo-battery icon'></span>
			</td>
			<td title='{$currently}: {$account->realEndurance()}' class='tipTip'>
				{$endurance}<br>
				{$bars->enduranceBar()}
			</td>
		</tr><tr>
			<td class='bottom'>
				<span class='entypo-rocket icon'></span>
			</td>
			<td title='{$currently}: {$account->realActionPoints()}' class='tipTip'>
				{$actionPoints}<br>
				{$bars->actionPointsBar()}
			</td>
		</tr>
	</table>
</div>";
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
		return false;
	}

}
