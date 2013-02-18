<?php

require_once './bootstrap.php';

require_once 'PHPUnit2/Framework/TestCase.php';
require_once './source/i18n.php';
require_once './source/configs/tech_config.php';
require_once './source/configs/space_config.php';

//$connection = new connection();
//$connection->connectDatabase(HOST_FOR_MYSQL, USER_FOR_MYSQL, PASS_FOR_MYSQL, DATABASE_FOR_MYSQL);

class phpUnitFramework extends PHPUnit_Framework_TestCase {
	public function mock(
		$className,
		$mockFunctions = array(),
		$parameters = array(),
		$callConstructor = false
	) {
		return $this->getMock(
			$className,
			$mockFunctions,
			$parameters,
			'',
			$callConstructor
		);
	}
}
