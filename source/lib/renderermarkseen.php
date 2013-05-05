<?php

class RendererMessageMarkSeen extends RendererAbstract {
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

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$messageId = $this->request()->get('mid');
		$message = new Message($messageId);

		if (!$message->valid()) {
			return '';
		}

		if (!$message->isRecipient($this->account())) {
			return '';
		}

		$message->setValue('seen', 1)->update();

		return '';
	}
}