<?php

class ControllerLogin extends ControllerAbstract {
	protected function remember() {
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
					MD5(CONCAT(`id`,  '_wow')) = '{$escapedUserKey}'
				LIMIT 1;";
			$result = $database->query($sql)->fetchOne();
			$database->freeResult();

			if ($result) {
				$session = new Leviathan_Session();
				$session->store('id', $result);

				$this->redirect(
					$this->route('profile')
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