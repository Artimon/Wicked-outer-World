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
class Account extends Lisbeth_Entity_Accounts {
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
	public static function register($name, $password, $email, $shipId, $language) {
		$database = new Lisbeth_Database();
		$name = $database->escape($name);
		$email = $database->escape($email);
		$password = md5($password);
		$shipId = (int)$shipId;
		$language = $database->escape($language);
		$timeRegistered = TIME;

		/** @var Account $account */
		$account = self::create(array(
			'name' => $name,
			'password' => $password,
			'email' => $email,
			'starshipId' => $shipId,
			'language' => $language,
			'timeRegistered' => $timeRegistered
		));

		$id = $account->id();

		$game = Game::getInstance();
		$game->session()->store('id', $id);

		crafting::create(array('accountId' => $id));
		$starship = StarshipData::create(array(
			'ownerId' => $id,
			'techId' => $shipId
		));

		$account->starshipId($starship->id());

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
	public function starbaseId() {
		return 1;
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
	public function realEndurance() {
		$endurance = (int)$this->get('endurance');

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
	public function realActionPoints() {
		$actionPoints = (int)$this->get('actionPoints');

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
	 * @param int $endurance
	 * @param int $actionPoints
	 * @return Lisbeth_Entity
	 */
	protected function applyTickValues($endurance, $actionPoints) {
		return $this
			->set('actionPoints', $endurance)
			->set('endurance', $actionPoints)
			->set('lastUpdate', TIME);
	}

	/**
	 * @TODO Move to "action" class.
	 *
	 * @param int $value
	 * @return Account
	 */
	public function incrementActionPoints($value) {
		return $this->applyTickValues(
			$this->realActionPoints() + $value,
			$this->realEndurance()
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
			$this->realActionPoints(),
			$this->realEndurance() + $value
		);
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
			->set('endurance', 20)
			->set('actionPoints', 7)
			->set('maxEndurance', 20)
			->set('maxActionPoints', 7)
			->set('lastUpdate', TIME)
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
	public function myMoney() {
		return ObjectPool::get()->money($this);
	}

	/**
	 * @return Bank
	 */
	public function myBank() {
		return ObjectPool::get()->bank($this);
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

	/**
	 * @param string $title
	 * @param string $message
	 * @param Account $sender
	 */
	public function newMessage($title, $message, Account $sender = null) {
		Message::send($title, $message, $this, $sender);
	}
}