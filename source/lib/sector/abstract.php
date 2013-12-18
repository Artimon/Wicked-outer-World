<?php

abstract class Sector_Abstract implements Sector_Interface {
	const KEY = -1;

	/**
	 * @return int
	 */
	public function key() {
		return static::KEY;
	}

	/**
	 * @return string
	 */
	public function description() {
		return $this->name() . 'Description';
	}

	/**
	 * @param Account $account
	 * @return Sector_Interface
	 */
	public static function getInstance(Account $account) {
		$sectorId = $account->sectorId();
		$sectors = self::raw();

		return $sectors[$sectorId];
	}

	/**
	 * @return Starbase
	 */
	public function starbase() {
		$starbaseName = $this->name() . 'StarbaseName';
		$starbase = new Starbase(static::KEY, $starbaseName);

		$this->addModules($starbase);

		return $starbase;
	}

	/**
	 * @param Starbase $starbase
	 */
	abstract protected function addModules(Starbase $starbase);

	/**
	 * @param Account $account
	 * @return array
	 */
	public function __toArray(Account $account) {
		$starbase = $this->starbase();
		$modules= array();

		foreach ($starbase->modules() as $module) {
			$modules[] = $module->__toArray();
		}

		$unlockPrice = $this->unlockPrice();

		return array(
			'key' => $this->key(),
			'name' => $this->name(),
			'description' => $this->description(),
			'isAvailable' => self::info($account, $this->key()),
			'unlockPrice' => $unlockPrice,
			'canAfford' => $account->premiumPrice()->set($unlockPrice)->canAfford(),
			'x' => $this->x(),
			'y' => $this->y(),
			'starbase' => $starbase->name(),
			'modules' => $modules
		);
	}

	/**
	 * @param Account $account
	 * @return array
	 */
	public static function __toListArray(Account $account) {
		$result = array();

		foreach (self::raw() as $sector) {
			$result[] = $sector->__toArray($account);
		}

		return $result;
	}

	/**
	 * @return Sector_Interface[]
	 */
	public static function raw() {
		return array(
			Sector_Earth::KEY => new Sector_Earth(),
			Sector_AsteroidField::KEY => new Sector_AsteroidField(),
			Sector_OldBattlefield::KEY => new Sector_OldBattlefield(),
			Sector_StarAcademy::KEY => new Sector_StarAcademy()
		);
	}

	/**
	 * @param Account $account
	 * @param int $sectorId
	 * @param bool|null $state
	 * @return Account|bool
	 */
	public static function info(Account $account, $sectorId, $state = null) {
		static $sectors;

		if ($sectors === null) {
			$sectors = json_decode(
				$account->knownSectors(),
				true
			);
		}

		if ($state === null) {
			$alwaysKnown = array(
				Sector_Earth::KEY,
				Sector_AsteroidField::KEY,
				Sector_OldBattlefield::KEY
			);

			if (in_array($sectorId, $alwaysKnown)) {
				return true;
			}

			if (!$sectors) {
				return false;
			}

			return array_key_exists($sectorId, $sectors);
		}

		$sectors[$sectorId] = (bool)$state;

		$account->knownSectors(
			json_encode($sectors)
		);

		return $account;
	}
}