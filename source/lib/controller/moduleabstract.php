<?php

abstract class Controller_ModuleAbstract extends Controller_Abstract {
	/**
	 * @param Starbase_Module_Abstract $module
	 */
	protected function assertModule($module) {
		$name = $module->name();
		$module = Game::getInstance()->account()->starbase()->module($name);

		if (!$module) {
			$this->redirect(
				$this->route('profile')
			);
		}
	}
}