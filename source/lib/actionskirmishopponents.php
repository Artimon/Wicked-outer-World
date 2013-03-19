<?php

class ActionSkirmishOpponents extends ActionAbstract {
	const ACTION_POINTS = 10;

	/**
	 * @return bool
	 */
	public function canStart() {
		return $this->hasActionPoints();
	}

	/**
	 * @return bool
	 */
	public function hasActionPoints() {
		$actionPoints = $this->account()->actionPoints();

		return ($actionPoints >= self::ACTION_POINTS);
	}

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

	public function start() {
		return;
	}
}
