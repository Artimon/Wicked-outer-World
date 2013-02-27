<?php

/**
 * Class instance holder class.
 */
class ObjectPool {
	/**
	 * @var array
	 */
	private static $instancesX = array();

	/**
	 * Return a class from object pool, using lazy initialisation.
	 *
	 * @deprecated
	 * @param	string	$className
	 * @param	int		$parameter
	 * @return	instance of given $className
	 */
	public static function getLegacy($className, $parameter = null) {
		$parameter = (int)$parameter;

		if (!isset(self::$instancesX[$className][$parameter])) {
			if (null === $parameter) {
				self::$instancesX[$className][$parameter] = new $className();
			} else {
				self::$instancesX[$className][$parameter] = new $className($parameter);
			}
		}

		return self::$instancesX[$className][$parameter];
	}

	/**
	 * Return a class from object pool.
	 *
	 * @param	string	$className
	 * @param	int		$parameter
	 * @return	instance of given $className
	 */
	public function create($className, $parameter = null) {
		return self::getLegacy($className, $parameter);
	}


	/**
	 * @var array
	 */
	private static $instances = array();

	/**
	 * @return ObjectPool
	 */
	public static function get() {
		return Lisbeth_ObjectPool::get('ObjectPool');
	}

	/**
	 * @param string $className
	 * @param object|int $parent
	 * @return mixed instance of subclass
	 */
	protected function fromPool($className, $parent) {
		$key = is_numeric($parent)
			? (int)$parent
			: spl_object_hash($parent);

		if (!isset(self::$instances[$className][$key])) {
			$instance = new $className($parent);

			self::$instances[$className][$key] = $instance;
		}

		return self::$instances[$className][$key];
	}

	/**
	 * @param int $id
	 * @return Account
	 */
	public function account($id) {
		return $this->fromPool('Account', $id);
	}

	/**
	 * @param Account $account
	 * @return AccountFactory
	 */
	public function accountFactory(Account $account) {
		return $this->fromPool('AccountFactory', $account);
	}

	/**
	 * @param Account $account
	 * @return Stats
	 */
	public function stats(Account $account) {
		return $this->fromPool('Stats', $account);
	}

	/**
	 * @param Account $account
	 * @return Bars
	 */
	public function bars(Account $account) {
		return $this->fromPool('Bars', $account);
	}

	/**
	 * @param Account $account
	 * @return Price
	 */
	public function price(Account $account) {
		return $this->fromPool('Price', $account);
	}

	/**
	 * @param Account $account
	 * @return LevelProgress
	 */
	public function levelProgress(Account $account) {
		return $this->fromPool('LevelProgress', $account);
	}

	/**
	 * @param Account $account
	 * @return Money
	 */
	public function money(Account $account) {
		return $this->fromPool('Money', $account);
	}

	/**
	 * @param Account $account
	 * @return ActionProfileHealthCare
	 */
	public function actionProfileHealthCare(Account $account) {
		return $this->fromPool('ActionProfileHealthCare', $account);
	}

	/**
	 * @param Account $account
	 * @return ActionAcademyCourse
	 */
	public function actionAcademyCourse(Account $account) {
		return $this->fromPool('ActionAcademyCourse', $account);
	}

	/**
	 * @param Account $account
	 * @return ActionAcademyTraining
	 */
	public function actionAcademyTraining(Account $account) {
		return $this->fromPool('ActionAcademyTraining', $account);
	}

	/**
	 * @param Account $account
	 * @return ActionHangarMission
	 */
	public function actionHangarMission(Account $account) {
		return $this->fromPool('ActionHangarMission', $account);
	}

	/**
	 * @param Account $account
	 * @return ActionHangarStarTrip
	 */
	public function actionHangarStarTrip(Account $account) {
		return $this->fromPool('ActionHangarStarTrip', $account);
	}

	/**
	 * @param Account $account
	 * @return ActionSkirmishOpponents
	 */
	public function actionSkirmishOpponents(Account $account) {
		return $this->fromPool('ActionSkirmishOpponents', $account);
	}
}