<?php

class RenderJumpGate extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$account = $this->account();
		$sectors = Sector_Abstract::__toListArray($account);

		$template = new Leviathan_Template();
		$template->assignArray(array(
			'sectors' => json_encode($sectors),
			'sectorId' => $account->sectorId(),
			'money' => $account->myMoney()->value(),
		));

		return $template->render('source/view/jumpGate.php');
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
		return true;
	}
}