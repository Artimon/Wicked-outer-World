<?php

class ActionSkirmishOpponents extends ActionAbstract {
	public function closeOpponents() {
		$experience = $this->account()->experience();

		$sql = "
			SELECT
				`id`,
				`name`,
				`experience`
			FROM
				`accounts`
			WHERE
				`experience` <= {$experience}
			LIMIT 21
			UNION ALL
			SELECT
				`id`,
				`name`,
				`experience`
			FROM
				`accounts`
			WHERE
				`experience` > {$experience}
			ORDER BY
				`experience` DESC
			LIMIT 20;";

		$database = new Lisbeth_Database();
		$result = $database->query($sql)->fetchAll();

		$database->freeResult();

		return $result;
	}

	/**
	 * @return bool
	 */
	public function canStart() {
		return true;
	}

	public function start() {
		return;
	}
}
