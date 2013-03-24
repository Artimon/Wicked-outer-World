<?php

class ActionSkirmishOpponents extends ActionAbstract {
	const LEVEL_DIFFERENCE = 3;

	public function closeOpponents() {
		$account = $this->account();

		$experience = $account->experience();
		$level = $account->level() - self::LEVEL_DIFFERENCE;

		$sql = "
			SELECT
				`id`,
				`name`,
				`experience`
			FROM
				`accounts`
			WHERE
				`experience` <= {$experience} AND
				`level` >= {$level}
			LIMIT 21
			UNION ALL
			SELECT
				`id`,
				`name`,
				`experience`
			FROM
				`accounts`
			WHERE
				`experience` > {$experience} AND
				`level` >= {$level}
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
