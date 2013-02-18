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
			<td>ico</td>
			<td>
				{$shipCondition}<br>
				{$bars->conditionBar()}
			</td>
		</tr><tr>
			<td>ico</td>
			<td title='{$currently}: {$account->endurance()}' class='tipTip'>
				{$endurance}<br>
				{$bars->enduranceBar()}
			</td>
		</tr><tr>
			<td>ico</td>
			<td title='{$currently}: {$account->actionPoints()}' class='tipTip'>
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
