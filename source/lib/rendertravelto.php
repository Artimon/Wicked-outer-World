<?php

class RenderTravelTo extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$account = $this->account();
		$sectorId = (int)$this->request()->json('sectorId');


		$sectors = Sector_Abstract::raw();
		if (!array_key_exists($sectorId, $sectors)) {
			return 'false';
		}

		$currentSectorId = $account->sectorId();
		if ($sectorId === $currentSectorId) {
			return 'false';
		}

		$hasSector = Sector_Abstract::info($account, $sectorId);
		if (!$hasSector) {
			return 'false';
		}

		$currentSector = $sectors[$currentSectorId];
		$sector = $sectors[$sectorId];
		$x = $sector->x() - $currentSector->x();
		$y = $sector->y() - $currentSector->y();

		$travelPrice = sqrt(($x * $x) + ($y * $y));
		$travelPrice = 0.015 * ($travelPrice * $travelPrice) + 1.75 * $travelPrice + 4;
		$travelPrice = round($travelPrice);

		$price = $account->price()->set($travelPrice);
		if (!$price->canAfford()) {
			return $this->json($account);
		}

		$price->buy();

		$account->sectorId($sectorId)->update();

		return 'true';
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