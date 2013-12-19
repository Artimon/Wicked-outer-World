<?php

class RenderUnlockSector extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$account = $this->account();
		$sectorId = (int)$this->request()->json('sectorId');


		$sectors = Sector_Abstract::raw();
		if (!array_key_exists($sectorId, $sectors)) {
			return $this->json($account);
		}

		$hasSector = Sector_Abstract::info($account, $sectorId);
		if ($hasSector) {
			return $this->json($account);
		}

		$sector = $sectors[$sectorId];

		$unlockPrice = $sector->unlockPrice();
		$premiumPrice = $account->premiumPrice()->set($unlockPrice);
		if (!$premiumPrice->canAfford()) {
			return $this->json($account);
		}

		if ($sector->unlockLevel() > $account->level()) {
			return $this->json($account);
		}

		$premiumPrice->buy();
		Sector_Abstract::info($account, $sectorId, true);

		$account->update();

		return $this->json($account);
	}

	/**
	 * @param Account $account
	 * @return string
	 */
	private function json(Account $account) {
		$sectors = Sector_Abstract::__toListArray($account);

		$template = new Leviathan_Template();
		$template->assignArray(array(
			'sectors' => $sectors,
			'premiumCoins' => $account->myMoney()->premiumCoins()
		));

		return $template->json();
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