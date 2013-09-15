<?php

/**
 * Handles account data entity.
 *
 * Hitpoints (fighter hits)
 * Endurance (chances relative to endurance)
 * Action points (needed for actions)
 *
 * About hitpoints:
 *  + Depends on the fighter model
 *  + Recreation based on nanites
 *
 * About endurance:
 *  + Increase amount by quarters improvement
 *  + Increase regeneration by quarters improvement
 *  - Drained by crafting
 *  - Drained by academy training
 *
 * About action points:
 *  + Start with 5
 *  + Increase by 1 every 2 academy training session
 *    -> Start academy training for money
 *    -> After time x you have to return and collect the certificate, no automated increase
 *  - Drained by crafting
 *  - Drained by academy training
 *
 * Tactics (accuracy):
 *
 * Astronautics (evasion):
 *
 * Crafting:
 *  + Increases experience
 *  - Consumes endurance
 *  - Consumes Action Points
 *  - Chance relative to Endurance
 *
 * "Premium Coins": Awkward Materia / Seltsame Materie
 */
class Account extends Lisbeth_Entity {
	/**
	 * @var string
	 */
	protected $table = 'accounts';

	/**
	 * @var stockage
	 */
	private $stockage;

	/**
	 * @var trashContainer
	 */
	private $trashContainer;

	/**
	 * @var crafting
	 */
	private $crafting;

	/**
	 * @param string $name
	 * @param string $password
	 * @param string $email
	 * @param int $shipId
	 * @param string $language
	 * @return Account
	 */
	public static function create($name, $password, $email, $shipId, $language) {
		$database = new Lisbeth_Database();
		$name = $database->escape($name);
		$email = $database->escape($email);
		$password = md5($password);
		$shipId = (int)$shipId;
		$language = $database->escape($language);

		$sql = "
			INSERT INTO `accounts`
			SET
				`name` = '{$name}',
				`password` = '{$password}',
				`email` = '{$email}',
				`starshipId` = {$shipId},
				`language` = '{$language}';";
		$database->query($sql)->freeResult();

		$id = mysql_insert_id();
		$game = Game::getInstance();
		$game->session()->store('id', $id);

		$sql = "
			INSERT INTO `crafting`
			SET
				`accountId` = {$id};";
		$database->query($sql)->freeResult();

		$account = $game->account();
		$stock = $account->stockage()->stock();
		$stock->newItem(SMALL_BLASTER_ID, 1);
		$stock->newItem(BLASTER_AMMUNITION_ID, 75);
		$stock->newItem(NUCLEAR_BATTERIES_ID, 1);
		$stock->newItem(COMBUSTION_DRIVE_ID, 1);
		$stock->update();

		return $account;
	}

	public function abandon() {
		$accountId = $this->id();
		$database = new Lisbeth_Database();

		$sql = "DELETE FROM `entities` WHERE `accountId` = {$accountId};";
		$database->query($sql)->freeResult();

		$sql = "DELETE FROM `messages` WHERE `recipientId` = {$accountId};";
		$database->query($sql)->freeResult();

		$sql = "DELETE FROM `crafting` WHERE `accountId` = {$accountId};";
		$database->query($sql)->freeResult();

		$sql = "DELETE FROM `accounts` WHERE `id` = {$accountId};";
		$database->query($sql)->freeResult();
	}

	/**
	 * @return int
	 */
	public function id() {
		return (int)$this->value('id');
	}

	/**
	 * @return string
	 */
	public function name() {
		return $this->value('name');
	}

	/**
	 * @return int
	 */
	public function targetId() {
		return $this->value('targetId');
	}

	/**
	 * @return int
	 */
	public function starbaseId() {
		return 1;
	}

	/**
	 * @return int
	 */
	public function level() {
		return (int)$this->value('level');
	}

	/**
	 * @return int
	 */
	public function experience() {
		return (int)$this->value('experience');
	}

	/**
	 * @return float
	 */
	public function repair() {
		return $this->starship()->repair();
	}

	/**
	 * Regenerate 3 endurance points in 5 minutes without improvements.
	 *
	 * @return int
	 */
	public function endurance() {
		$endurance = (int)$this->value('endurance');

		return min(
			$endurance + (3 * $this->passedTicks()),
			$this->maxEndurance()
		);
	}

	/**
	 * Regenerate 2 action points in 5 minutes without improvements.
	 *
	 * @return int
	 */
	public function actionPoints() {
		$actionPoints = (int)$this->value('actionPoints');

		return min(
			$actionPoints + (2 * $this->passedTicks()),
			$this->maxActionPoints()
		);
	}

	/**
	 * @return int
	 */
	public function maxEndurance() {
		return 20;	// + items
	}

	/**
	 * @return int
	 */
	public function maxActionPoints() {
		$actionPoints = $this->academyCourseLevel();
		$actionPoints = (int)($actionPoints / 2);
		$actionPoints += 7;

		return $actionPoints;
	}

	/**
	 * @return int
	 */
	public function academyCourseLevel() {
		return (int)$this->value('academyCourseLevel');
	}

	/**
	 * @return int
	 */
	public function academyCourseTime() {
		return (int)$this->value('academyCourseTime');
	}

	/**
	 * @param int $endurance
	 * @param int $actionPoints
	 * @return Lisbeth_Entity
	 */
	protected function applyTickValues($endurance, $actionPoints) {
		return $this
			->setValue('actionPoints', $endurance)
			->setValue('endurance', $actionPoints)
			->setValue('lastUpdate', TIME);
	}

	/**
	 * @TODO Move to "action" class.
	 *
	 * @param int $value
	 * @return Account
	 */
	public function incrementActionPoints($value) {
		return $this->applyTickValues(
			$this->actionPoints() + $value,
			$this->endurance()
		);
	}

	/**
	 * @TODO Move to "action" class.
	 *
	 * @param int $value
	 * @return Account
	 */
	public function incrementEndurance($value) {
		if ($value < 0) {
			// @TODO Use "level class".
			$this->increment('experience', -$value);
		}

		return $this->applyTickValues(
			$this->actionPoints(),
			$this->endurance() + $value
		);
	}

	/**
	 * @return int
	 */
	public function lastUpdate() {
		return (int)$this->value('lastUpdate');
	}

	/**
	 * @return int
	 */
	public function lastHealthCare() {
		return (int)$this->value('lastHealthCare');
	}

	/**
	 * One tick every 5 minutes.
	 *
	 * @return int ticks since last update
	 */
	public function passedTicks() {
		$seconds = 300;

		$lastUpdate = (int)($this->lastUpdate() / $seconds);
		$now = (int)(TIME / $seconds);

		return ($now - $lastUpdate);
	}

	/**
	 * @return bool
	 */
	public function reset() {
		return $this
			->setValue('endurance', 20)
			->setValue('actionPoints', 7)
			->setValue('maxEndurance', 20)
			->setValue('maxActionPoints', 7)
			->setValue('lastUpdate', TIME)
			->update();
	}

	/**
	 * @return Starbase
	 */
	public function starbase() {
		return entityPool::starbase(
			$this->starbaseId()
		);
	}

	/**
	 * Note:
	 * Do not cache, may change.
	 *
	 * @return Starship
	 */
	public function starship() {
		return Starship::create($this);
	}

	/**
	 * @return Starships
	 */
	public function starships() {
		return Lisbeth_ObjectPool::get(
			'Starships',
			$this->id()
		);
	}

	/**
	 * @return stockage
	 */
	public function stockage() {
		if ($this->stockage === null) {
			$this->stockage = new stockage($this, -1, 1);
		}

		return $this->stockage;
	}

	/**
	 * @return trashContainer
	 */
	public function trashContainer() {
		if ($this->trashContainer === null) {
			$this->trashContainer = new trashContainer($this, -1, 1);
		}

		return $this->trashContainer;
	}

	/**
	 * @return Stats
	 */
	public function stats() {
		return ObjectPool::get()->stats($this);
	}

	/**
	 * @return Bars
	 */
	public function bars() {
		return ObjectPool::get()->bars($this);
	}

	/**
	 * @return Price
	 */
	public function price() {
		return ObjectPool::get()->price($this);
	}

	/**
	 * @return LevelProgress
	 */
	public function levelProgress() {
		return ObjectPool::get()->levelProgress($this);
	}

	/**
	 * @return Money
	 */
	public function money() {
		return ObjectPool::get()->money($this);
	}

	/**
	 * @return Bank
	 */
	public function bank() {
		return ObjectPool::get()->bank($this);
	}

	/**
	 * @return int
	 */
	public function tacticsLevel() {
		return (int)$this->value('tacticsLevel');
	}

	/**
	 * @return int
	 */
	public function tacticsExperience() {
		return (int)$this->value('tacticsExperience');
	}

	/**
	 * @return int
	 */
	public function defenseLevel() {
		return (int)$this->value('defenseLevel');
	}

	/**
	 * @return int
	 */
	public function defenseExperience() {
		return (int)$this->value('defenseExperience');
	}

	/**
	 * @return int
	 */
	public function craftingLevel() {
		return (int)$this->value('craftingLevel');
	}

	/**
	 * @return int
	 */
	public function craftingExperience() {
		return (int)$this->value('craftingExperience');
	}

	/**
	 * @return AccountFactory
	 */
	public function factory() {
		return ObjectPool::get()->accountFactory($this);
	}

	/**
	 * @return crafting
	 */
	public function crafting() {
		if ($this->crafting === null) {
			$this->crafting = new crafting($this->id());
		}

		return $this->crafting;
	}
}