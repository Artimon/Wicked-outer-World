<?php

class ControllerLogin extends ControllerAbstract {
	protected function remember() {
		if (Game::getInstance()->isOnline()) {
			$this->redirect(
				$this->route('profile')
			);
		}

		$cookie = new Leviathan_Cookie();

		$userKey = $cookie->value('user');
		if ($userKey) {
			$database = new Lisbeth_Database();
			$escapedUserKey = $database->escape($userKey);

			$sql = "
				SELECT
					`id`
				FROM
					`accounts`
				WHERE
					MD5(CONCAT(`id`,  `password`)) = '{$escapedUserKey}'
				LIMIT 1;";
			$result = $database->query($sql)->fetchOne();
			$database->freeResult();

			if ($result) {
				$session = new Leviathan_Session();
				$session->store('id', $result);

				$continue = $this->request()->get('continue');
				if (!$continue) {
					$continue = 'profile';
				}

				$this->redirect(
					$this->route($continue)
				);
			}
		}
	}

	/**
	 * @param string $section
	 * @return RendererInterface|RenderLogin
	 */
	public function renderer($section) {
		$this->remember();

		$renderer = new RenderLogin();

		return $renderer->setController($this);
	}
}