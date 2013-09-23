<?php

/**
 * Handles starship designer rendering.
 *
 * Weapons
 * Ammunition
 * Equipment
 * Cargo
 * Engine
 */
class RenderHangarDesigner extends RenderHangarAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$this->shipActions();
		$this->moveItem();
		$this->energySetup();

		return $this->setupHtml();
	}

	/**
	 * @return string
	 */
	private function setupHtml() {
		$starship = $this->account()->starship();
		$stockage = $this->account()->stockage();

		$selectorHtml = $this->selectorHtml(
			$this->account()
		);

		$designerHtml = "
<colgroup>
	<col width='40'>
	<col>
	<col>
</colgroup>
<tr>
	<td colspan='2'>
		".i18n('yourStarship')."<br>
		<span class='highlight'>
			{$starship->name()}
			({$starship->weight()}t / {$starship->maxWeight()}t)
		</span>
	</td>
</tr>";

		$designerHtml .= plugins::itemList($stockage, $starship->weaponry(),	i18n('remove'));
		$designerHtml .= plugins::itemList($stockage, $starship->ammunition(),	i18n('remove'));
		$designerHtml .= plugins::itemList($stockage, $starship->equipment(),	i18n('remove'));
		$designerHtml .= plugins::itemList($stockage, $starship->cargo(),		i18n('remove'));
		$designerHtml .= plugins::itemList($stockage, $starship->engine(),		i18n('remove'));

		$designerHtml .= "
<tr>
	<td colspan='2' class='headline'>
		".i18n('yourStuff')."<br>
		<span class='highlight'>
			".$stockage->name()."
			(".$stockage->payload()."t / ".$stockage->tonnage()."t)
		</span>
	</td>
</tr>";

		$designerHtml .= plugins::itemList($starship, $stockage->stock(),			i18n('equip'), false);

		$howMany = i18n('howMany');
		JavaScript::create()->bind("$('.moveItem').moveItem('{$howMany}');");

		$designerHtml = html::defaultTable($designerHtml);
		$detailsHtml = $this->statusHtml();
		$detailsHtml = Plugins::box(
			i18n('yourShip'),
			$detailsHtml
		);

		return "
<div id='garage'>
	<h2>".i18n('garage')."</h2>
	<p>".i18n('garageDescription')."</p>
	{$selectorHtml}
	<div class='floatRight columnRight'>{$detailsHtml}</div>
	<div class='floatLeft columnLeft'>{$designerHtml}</div>
	<div class='clear'></div>
</div>";
	}

	/**
	 * @param Account $account
	 * @return string
	 */
	private function selectorHtml(Account $account) {
		$raw = array(
			'id' => null,
			'name' => '',
			'current' => false,
			'urlSelect' => 'javascript:;',
			'urlScrap' => 'javascript:;'
		);
		$data = array($raw, $raw, $raw);

		$currentStarshipId = $account->starship()->data()->id();
		$starships = $account->starships()->allStarships();
		foreach ($starships as $key => $starship) {
			$starshipId = $starship->data()->id();
			$isCurrent = $starshipId === $currentStarshipId;

			$urlSelect = $isCurrent
				? 'javascript:;'
				: $this->controller()->currentSection(array('select' => $starshipId));

			$urlScrap = $isCurrent
				? 'javascript:;'
				: $this->controller()->currentSection(array('scrap' => $starshipId));

			$data[$key] = array(
				'id' => $starshipId,
				'name' => $starship->name(),
				'current' => $isCurrent,
				'urlSelect' => $urlSelect,
				'urlScrap' => $urlScrap
			);
		}

		$data = json_encode($data);

		return "
<ul class='starshipSelector' ng-controller='StarshipSelectorCtrl'
	ng-init='setup({$data})'
	ng-show='starships.length > 1'>
	<li ng-repeat='starship in starships'>
		<p class='variable'>{{starshipName(starship)|i18n}}</p>

		<a ng-href='{{starship.urlSelect}}' class='button merge first'
			ng-class='{ disabled: !starship.id || starship.current }'>
			{{actionText(starship)|i18n}}
		</a><a ng-href='{{starship.urlScrap}}' class='button merge last'
			ng-class='{ disabled: !starship.id || starship.current }'
			ng-click='scrap(\$event, starship)'>
			{{'scrap'|i18n}}
		</a>
	</li>
</ul>
<div class='clear'></div>";
	}

	/**
	 * @return string
	 */
	private function statusHtml() {
		$starship = $this->account()->starship();
		$movability = Format::number($starship->movability(), 1);

		$energySetupSelected = $starship->isEnergyToShields()
			? " selected='selected'"
			: '';

		$html = "
<colgroup>
	<col width='180'>
	<col width='80'>
</colgroup>
<tr>
	<td colspan='2' class='headline'>".i18n('weight')."</td>
</tr><tr>
	<td>".i18n('payload').":</td>
	<td class='variable right'>{$starship->payload()}t</td>
</tr><tr>
	<td>".i18n('tonnage').":</td>
	<td class='variable right'>{$starship->tonnage()}t</td>
</tr><tr>
	<td>".i18n('weight').":</td>
	<td class='variable right'>{$starship->weight()}t</td>
</tr><tr>
	<td colspan='2' class='headline'>".i18n('partEngine')."</td>
</tr><tr>
	<td>".i18n('thrust').":</td>
	<td class='variable right'>{$starship->thrust()}MN</td>
</tr><tr>
	<td>".i18n('movability').":</td>
	<td class='variable right'>{$movability}</td>
</tr><tr>
	<td colspan='2' class='headline'>".i18n('technicalData')."</td>
</tr><tr>
	<td>".i18n('possibleDamagePerRound').":</td>
	<td class='variable right'>".Format::number($starship->damagePerRound(), 1)."</td>
</tr><tr>
	<td>".i18n('internalStructure').":</td>
	<td class='variable right'>".Format::number($starship->structure(), 1)."</td>
</tr><tr>
	<td>".i18n('additionalArmor').":</td>
	<td class='variable right'>".Format::number($starship->armor(), 1)."</td>
</tr><tr>
	<td colspan='2' class='headline'>".i18n('energyManagement')."</td>
</tr><tr>
	<td>".i18n('drainPerRound').":</td>
	<td class='variable right'>".Format::number($starship->drainPerRound(), 1)."</td>
</tr><tr>
	<td>".i18n('rechargePerRound').":</td>
	<td class='variable right'>".Format::number($starship->rechargePerRound(), 1)."</td>
</tr><tr>
	<td>".i18n('capacity').":</td>
	<td class='variable right'>".Format::number($starship->capacity(), 1)."</td>
</tr><tr>
	<td colspan='2' class='headline'>{{\"mainEnergyTo\"|i18n}}</td>
</tr><tr>
	<td colspan='2'>
		<form action='{$this->controller()->currentSection()}' method='post'>
			<select name='energySetup'>
				<option value='0'>{{\"weapons\"|i18n}}</option>
				<option value='1'{$energySetupSelected}>{{\"shields\"|i18n}}</option>
			</select>
			<input type='submit' value='{{\"save\"|i18n}}' class='button'>
		</form>
	</td>
</tr>";

		return html::defaultTable($html);
	}

	public function shipActions() {
		$request = Leviathan_Request::getInstance();

		$starshipId = $request->get('select');
		if ($starshipId) {
			$account = $this->account();

			$starship = $account->starships()->starship($starshipId);

			if ($starship) {
				$account->setValue('starshipId', $starshipId)->update();
			}
		}

		$starshipId = $request->get('scrap');
		if ($starshipId) {
			$account = $this->account();

			$starships = $account->starships();
			$starship = $starships->starship($starshipId);

			if ($starship && !$starship->isSelected()) {
				$starship->data()->delete();
				$starships->removeEntity($starshipId);
			}
		}
	}

	/**
	 * @return void
	 */
	public function moveItem() {
		$request = Leviathan_Request::getInstance();

		$techId = $request->post('techId');
		$amount = (int)$request->post('amount');
		if (!$techId || $amount <= 0) {
			return;
		}

		$starship = $this->account()->starship();
		$stockage = $this->account()->stockage();

		$group = $request->post('slot');
		if ($starship->hasGroup($group)) {
			$techGroup = $starship->groupByName($group);

			if ($techGroup->hasItem($techId)) {
				$techGroup->moveItemTo(
					$stockage->stock(),
					$techGroup->item($techId),
					$amount
				);
			}
		}

		if ($stockage->hasGroup($group)) {
			$techGroup = $stockage->groupByName($group);

			if ($techGroup->hasItem($techId)) {
				$item = $techGroup->item($techId);

				$techGroup->moveItemTo(
					$starship->itemSlot($item),
					$item,
					$amount
				);
			}
		}
	}

	public function energySetup() {
		$request = Leviathan_Request::getInstance();

		$energySetup = $request->post('energySetup');
		if ($energySetup === null) {
			return;
		}

		$energySetup = (int)$energySetup;
		if (
			$energySetup !== Starship::ENERGY_TO_SHIELDS &&
			$energySetup !== Starship::ENERGY_TO_WEAPONS
		) {
			return;
		}

		$this->account()->starship()->data()->setValue(
			'energySetup',
			$energySetup
		)->update();

		EventBox::get()->success("{{'newEnergySetup'|i18n}}");
	}
}