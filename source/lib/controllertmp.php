<?php

class RendererTmp extends RendererAbstract {
	public function bodyHtml() {
		return 'Done';
	}

	public function usesBox() {
		return true;
	}

	public function tabsHtml() {
		return '';
	}
}

class ControllerTmp extends ControllerAbstract {
	public function renderer($section) {
		$database = new Lisbeth_Database();
		$database->query("SELECT * FROM accounts;");
		$accounts = $database->fetchAll();
		$database->freeResult();

		foreach ($accounts as $account) {
			$database->query("
				INSERT INTO starships
				SET
					ownerId = {$account['id']},
					techId = {$account['starshipId']},
					repair = {$account['repair']},
					energySetup = {$account['energySetup']},
					itemsWeaponry = '{$account['itemsWeaponry']}',
					itemsAmmunition = '{$account['itemsAmmunition']}',
					itemsEquipment = '{$account['itemsEquipment']}',
					itemsCargo = '{$account['itemsCargo']}',
					itemsEngine = '{$account['itemsEngine']}'
			");

			$starshipId = $database->insertId();
			Lisbeth_ObjectPool::get('Account', $account['id'])
				->setValue('starshipId', $starshipId)
				->update();
		}

		return new RendererTmp();
	}
}