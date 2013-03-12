<?php

class Register {
	/**
	 * @var bool
	 */
	private $valid = true;

	/**
	 * @var array
	 */
	private $invalid = array();

	/**
	 * @param string $name
	 * @param string $password
	 * @param string $email
	 * @param string $url
	 * @param int $shipId
	 * @return array
	 */
	public function commit($name, $password, $email, $url, $shipId) {
		if ($this->valid($name, $password, $email, $url, $shipId)) {
			Account::create($name, $password, $email, $shipId);
		}

		return $this->invalid;
	}

	/**
	 * @param string $name
	 * @param string $password
	 * @param string $email
	 * @param string $url
	 * @param int $shipId
	 * @return bool
	 */
	public function valid($name, $password, $email, $url, $shipId) {
		$name		= (string)$name;
		$password	= (string)$password;
		$email		= (string)$email;
		$url		= (string)$url;
		$shipId		= (int)$shipId;

		if ($url) {
			$this->valid = false;
			$this->invalid['bot'] = 'bot registration';
		}

		$emailValidator = new Leviathan_Validator_Email($email);
		if (!$emailValidator->valid()) {
			$this->valid = false;
			$this->invalid['email'] = 'invalid email';
		}

		$usernameValidator = new Leviathan_Validator_Username($name);
		if (!$usernameValidator->valid()) {
			$this->valid = false;
			$this->invalid['name'] = i18n('nameTip');
		}

		if ($this->accountExists($name)) {
			$this->valid = false;
			$this->invalid['name'] = i18n('usernameTaken');
			$this->invalid['taken'] = 'username taken';
		}

		if (empty($password)) {
			$this->valid = false;
			$this->invalid['password'] = 'password empty';
		}

		if (!in_array($shipId, self::startupStarshipIds())) {
			$this->valid = false;
			$this->invalid['starship'] = 'starship not available';
		}

		return $this->valid;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function accountExists($name) {
		$database = new Lisbeth_Database();
		$name = $database->escape($name);

		$sql = "
			SELECT
				COUNT(*) as `amount`
			FROM
				`accounts`
			WHERE
				`name` = '{$name}';";
		$amount = (int)$database->query($sql)->fetchOne();

		$database->freeResult();

		return ($amount > 0);
	}

	/**
	 * @return array
	 */
	public static function startupStarshipIds() {
		return array(1, 2);
	}
}
