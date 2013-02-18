<?php

class RenderTechInfo extends RendererAbstract {
	/**
	 * @var technology
	 */
	private $item;

	/**
	 * @param technology $item
	 */
	public function __construct(technology $item) {
		$this->item = $item;
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		return "
<h2>{$this->item->name()}</h2>
<p>{$this->item->description()}</p>".$this->techData();
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	public function usesBox() {
		return false;
	}

	/**
	 * @return string
	 */
	private function weightUnit() {
		if ($this->item->weight() === 1) {
			return i18n('ton');
		} else {
			return i18n('tons');
		}
	}

	/**
	 * @return string
	 */
	private function starshipData() {
		return "@TODO create data list".$this->item->id();
	}

	/**
	 * @return string
	 */
	private function weaponData() {
		$burst = $this->item->burst();
		if ($burst === 1) {
			$burst = '-';
			$burstShots = '';
		} else {
			$burstShots = i18n('perShot');
		}

		$ammunition = $this->item->ammunitionId();
		if ($ammunition) {
			$ammunitionType = $ammunition->name().' '.i18n('perShot');
		} else {
			$ammunitionType = '';
		}

		$html = "
<colgroup>
	<col>
	<col width='40'>
	<col>
</colgroup>
<tr>
	<td>".i18n('weight').":</td>
	<td class='headline right'>{$this->item->weight()}</td>
	<td class='variable'>{$this->weightUnit()}</td>
</tr><tr>
	<td>".i18n('energyDrain').":</td>
	<td class='headline right'>{$this->item->drain()}</td>
	<td class='variable'>".i18n('perShot')."</td>
</tr><tr>
	<td>".i18n('burst').":</td>
	<td class='headline right'>{$burst}</td>
	<td class='variable'>{$burstShots}</td>
</tr><tr>
	<td>".i18n('ammunition').":</td>
	<td class='headline right'>{$burst}</td>
	<td class='variable'>{$ammunitionType}</td>
</tr><tr>
	<td>".i18n('damage').":</td>
	<td class='headline right'>{$this->item->damage()}</td>
	<td class='variable'>({$this->item->damageTypeName()})</td>
</tr><tr>
	<td>".i18n('reloadCycle').":</td>
	<td class='headline right'>{$this->item->reload()}</td>
	<td class='variable'>".i18n('rounds')."</td>
</tr>";

		return html::defaultTable($html);
	}

	/**
	 * @return string
	 */
	private function ammunitionData() {
		$html = "
<colgroup>
	<col>
	<col width='40'>
	<col>
</colgroup>
<tr>
	<td>".i18n('weight').":</td>
	<td class='headline right'>{$this->item->weight()}</td>
	<td class='variable'>{$this->weightUnit()} / {$this->item->stackSize()}</td>
</tr>";

		return html::defaultTable($html);
	}

	/**
	 * @return string
	 */
	private function platingData() {
		$html = "
<colgroup>
	<col>
	<col width='40'>
	<col>
</colgroup>
<tr>
	<td>".i18n('weight').":</td>
	<td class='headline right'>{$this->item->weight()}</td>
	<td class='variable'>{$this->weightUnit()}</td>
</tr><tr>
	<td>".i18n('armor').":</td>
	<td class='headline right'>{$this->item->armor()}</td>
	<td class='variable'>/ ".i18n('ton')."</td>
</tr>";

		return html::defaultTable($html);
	}

	/**
	 * @return string
	 */
	private function shieldData() {
		$html = "
<colgroup>
	<col>
	<col width='40'>
	<col>
</colgroup>
<tr>
	<td>".i18n('weight').":</td>
	<td class='headline right'>{$this->item->weight()}</td>
	<td class='variable'>{$this->weightUnit()}</td>
</tr><tr>
	<td>".i18n('energyDrain').":</td>
	<td class='headline right'>{$this->item->shieldBuildUpDrain()}</td>
	<td class='variable'>".i18n('energy')." ".i18n('perBuildUp')."</td>
</tr><tr>
	<td>".i18n('maxShieldRecharge').":</td>
	<td class='headline right'>{$this->item->shieldRechargeDrain()}</td>
	<td class='variable'>".i18n('energyPerRound')."</td>
</tr><tr>
	<td>".i18n('shieldStrength').":</td>
	<td class='headline right'>{$this->item->shieldStrengthPerEnergy()}</td>
	<td class='variable'>".i18n('perEnergyUnit')."</td>
</tr><tr>
	<td>".i18n('maxShieldStrength').":</td>
	<td class='headline right'>{$this->item->shieldMaxStrength()}</td>
	<td class='variable'>(".i18n('energyDrain')." * ".i18n('shieldStrength').")</td>
</tr><tr>
	<td class='top'>".i18n('absorbs').":</td>
	<td class='headline right'>
		{$this->item->shieldAbsorb(technology::DAMAGE_KINETIC)}<br>
		{$this->item->shieldAbsorb(technology::DAMAGE_ENERGY)}
	</td>
	<td class='variable'>
		(".i18n('kinetic').")<br>
		(".i18n('energy').")
	</td>
</tr>";

		return html::defaultTable($html);
	}

	/**
	 * @return string
	 */
	private function reactorData() {
		$html = "
<colgroup>
	<col>
	<col width='40'>
	<col>
</colgroup>
<tr>
	<td>".i18n('weight').":</td>
	<td class='headline right'>{$this->item->weight()}</td>
	<td class='variable'>{$this->weightUnit()}</td>
</tr><tr>
	<td>".i18n('recharge').":</td>
	<td class='headline right'>{$this->item->recharge()}</td>
	<td class='variable'>".i18n('perRound')."</td>
</tr><tr>
	<td>".i18n('maxCapacity').":</td>
	<td class='headline right'>{$this->item->capacity()}</td>
	<td class='variable'></td>
</tr>";

		return html::defaultTable($html);
	}

	/**
	 * @return string
	 */
	private function techData() {
		switch (true) {
			case $this->item->isStarship():
				return $this->starshipData();

			case $this->item->isWeapon():
				return $this->weaponData();

			case $this->item->isAmmunition():
				return $this->ammunitionData();

			case $this->item->isMiningModule():
				//return $this->ammunitionData();

			case $this->item->isPlating():
				return $this->platingData();

			case $this->item->isShield():
				return $this->shieldData();

			case $this->item->isReactor():
				return $this->reactorData();

			default:
				return '';
		}
	}
}