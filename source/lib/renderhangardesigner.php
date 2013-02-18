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
		$this->moveItem();

		return $this->setupHtml();
	}

	/**
	 * @return string
	 */
	private function setupHtml() {
		$starship = $this->account()->starship();
		$stockage = $this->account()->stockage();

		$html = "
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

		$html .= $this->itemList($stockage, $starship->weaponry(),		i18n('remove'));
		$html .= $this->itemList($stockage, $starship->ammunition(),	i18n('remove'));
		$html .= $this->itemList($stockage, $starship->equipment(),		i18n('remove'));
		$html .= $this->itemList($stockage, $starship->cargo(),			i18n('remove'));
		$html .= $this->itemList($stockage, $starship->engine(),		i18n('remove'));

		$html .= "
<tr>
	<td colspan='2' class='headline'>
			".i18n('yourStuff')."<br>
		<span class='highlight'>
			".$stockage->name()."
			(".$stockage->payload()."t / ".$stockage->tonnage()."t)
		</span>
	</td>
</tr>";

		$html .= $this->itemList($starship, $stockage->stock(),			i18n('equip'), false);

		$howMany = i18n('howMany');
		JavaScript::create()->bind("$('.moveItem').moveItem('{$howMany}');");

		$html = html::defaultTable($html);
		$html = "
<h2>".i18n('garage')."</h2>
<p>".i18n('garageDescription')."</p>
".$html;

		return $html;
	}

	/**
	 * @return string
	 */
	private function statusHtml() {
		$starship = $this->account()->starship();

		$html = "
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
</tr>";

		return html::defaultTable($html);
	}

	/**
	 * @param techContainerInterface $techContainer
	 * @param techGroup $techGroup
	 * @param string $buttonText
	 * @param bool $addHeadline
	 * @return string
	 */
	private function itemList(
		techContainerInterface $techContainer,
		techGroup $techGroup,
		$buttonText,
		$addHeadline = true
	) {
		$group = $techGroup->type();

		$html = '';
		if ($addHeadline) {
			$html .= "
<tr>
	<td colspan='2' class='headline'>".i18n($techGroup->type())."</td>
</tr>";
		}

		$items = $techGroup->items();
		if (count($items) > 0) {
			foreach ($items as $item) {
				$amount = $item->amount();

				if ($item->isStackable()) {
					$amountInfo = " ({$amount})";
					$weight = $item->totalWeight();
				}
				else {
					$amountInfo = '';
					$weight = $item->weight();
				}

				$loadableAmount = $techContainer->loadableAmount($item);
				if (!$item->isStackable()) {
					// Prevent selector menu for unstackable items.
					$loadableAmount = min(1, $loadableAmount);
				}

				$repeat = $item->slotUsage();
				while ($repeat-- > 0) {
					$techId = $item->id();

					$class = 'moveItem button';
					if ($loadableAmount <= 0) {
						$class .= ' disabled';
					}

					$html .= "
<tr>
	<td>{$weight}t</td>
	<td class='variable'>{$item->name()}{$amountInfo}</td>
	<td>
		<form action='' method='post'>
			<input type='button' class='techInfo button small' value='Info' data-techId='{$techId}'>

			<input type='hidden' name='slot' value='{$group}'>
			<input type='hidden' name='techId' value='{$techId}'>
			<input type='hidden' name='amount' value='1' class='amount'>
			<input type='hidden' name='possible' value='{$loadableAmount}' class='possible'>
			<input type='submit' class='{$class}' value='{$buttonText}'>
		</form>
	</td>
</tr>";
				}
			}
		}

		$availableSlots = $techGroup->slotsAvailable();
		while ($availableSlots-- > 0) {
			$html .= "
<tr>
	<td></td>
	<td>- ".i18n('empty')." -</td>
</tr>";
		}

		return $html;
	}

	/**
	 * @return void
	 */
	public function moveItem() {
		$request = Request::getInstance();

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
			$item = $techGroup->item($techId);

			$techGroup->moveItemTo(
				$stockage->stock(),
				$item,
				$amount
			);
		}

		if ($stockage->hasGroup($group)) {
			$techGroup = $stockage->groupByName($group);
			$item = $techGroup->item($techId);

			$techGroup->moveItemTo(
				$starship->itemSlot($item),
				$item,
				$amount
			);
		}
	}
}