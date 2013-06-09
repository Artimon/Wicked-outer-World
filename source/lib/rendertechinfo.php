<?php

class RenderTechInfo extends RendererAbstract {
	/**
	 * @var Technology
	 */
	private $item;

	/**
	 * @param Technology $item
	 */
	public function __construct(Technology $item) {
		$this->item = $item;
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$neededLevel = i18n('neededLevel', $this->item->level());

		return "
<h2>{$this->item->name()}</h2>
<div>
	<p class='critical bold'>{$neededLevel}</p>
	<p>{$this->item->description()}</p>
	{$this->techData()}
</div>";
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
	<td>".i18n('tonnage').":</td>
	<td class='headline right'>{$this->item->tonnage()}</td>
	<td class='variable'>{$this->weightUnit()}</td>
</tr><tr>
	<td>".i18n('internalStructure').":</td>
	<td class='headline right'>{$this->item->structure()}</td>
</tr><tr>
	<td class='headline'>" . i18n('slots') . "</td>
</tr><tr>
	<td>".i18n('weaponry').":</td>
	<td class='headline right'>{$this->item->weaponrySlots()}</td>
</tr><tr>
	<td>".i18n('ammunition').":</td>
	<td class='headline right'>{$this->item->ammunitionSlots()}</td>
</tr><tr>
	<td>".i18n('equipment').":</td>
	<td class='headline right'>{$this->item->equipmentSlots()}</td>
</tr><tr>
	<td>".i18n('cargo').":</td>
	<td class='headline right'>{$this->item->cargoSlots()}</td>
</tr><tr>
	<td>".i18n('engine').":</td>
	<td class='headline right'>{$this->item->engineSlots()}</td>
</tr>";

		return html::defaultTable($html);
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

		$ammunitionBurst = $burst;

		$ammunition = $this->item->ammunitionItem();
		if ($ammunition) {
			$ammunitionType = $ammunition->name().' '.i18n('perShot');
		}
		else {
			$ammunitionBurst = '-';
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
	<td class='headline right'>{$ammunitionBurst}</td>
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
		{$this->item->shieldAbsorb(Technology::DAMAGE_KINETIC)}<br>
		{$this->item->shieldAbsorb(Technology::DAMAGE_ENERGY)}
	</td>
	<td class='variable'>
		(".i18n('kinetic').")<br>
		(".i18n('energy').")
	</td>
</tr>";

		return html::defaultTable($html) . "<hr>" . i18n('shieldsHelp');
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
	<td class='variable'>".i18n('energy')."</td>
</tr>";

		return html::defaultTable($html) . "<hr>" . i18n('reactorHelp');
	}

	/**
	 * @return string
	 */
	private function driveData() {
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
	<td>".i18n('thrust').":</td>
	<td class='headline right'>{$this->item->thrust()}</td>
	<td class='variable'>Mega Newton (MN)</td>
</tr><tr>
	<td>".i18n('starTripDuration').":</td>
	<td class='headline right'>{$this->item->starTripSeconds()}</td>
	<td class='variable'>".i18n('seconds')."</td>
</tr>";

		return html::defaultTable($html) . "<hr>" . i18n('driveHelp');
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
			case $this->item->isCapacitor():
				return $this->reactorData();

			case $this->item->isDrive():
				return $this->driveData();

			default:
				return '';
		}
	}
}