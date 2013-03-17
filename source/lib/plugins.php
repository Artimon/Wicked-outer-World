<?php

class Plugins {
	/**
	 * @param string $class
	 * @param int $max
	 * @param int $current
	 * @return string
	 */
	public static function statusBar($class, $max, $current) {
		$max = (int)$max;
		$current = (int)$current;

		$width = 0;
		if ($current > 0) {
			$width = round(99 * ($current / $max));
		}

		return "
<div class='statusBar tipTip' title='{$current} / {$max}'>
	<div class='display {$class}' style='width: {$width}px'></div>
</div>";
	}

	/**
	 * @param string $class
	 * @return string
	 */
	public static function progressBar($class = '') {
		$class = empty($class)
			? 'progressBar'
			: 'progressBar ' . $class;

		return "
			<div class='{$class}'>
				<span></span>
			</div>";
	}

	/**
	 * @param string $head
	 * @param string $body
	 * @return string
	 */
	public static function box($head, $body) {
		return "
<div class='box'>
	<h3 class='header'>{$head}</h3>
	<div class='content'>{$body}</div>
</div>";
	}

	/**
	 * Note:
	 * Return only a tr-list that has to be "tabled".
	 *
	 * @param techContainerInterface $techContainer (target)
	 * @param techGroup $techGroup (from)
	 * @param string $buttonText
	 * @param bool $addHeadline
	 * @return string
	 */
	public static function itemList(
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
}
