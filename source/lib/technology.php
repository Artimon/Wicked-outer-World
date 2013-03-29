<?php

/**
 * Handles Technology.
 */
class Technology extends AccountSubclass{
	const TYPE_STOCKAGE			= 0;	// Item stockage
	const TYPE_STARSHIP			= 1;	// Starships
	const TYPE_WEAPON			= 2;	// Weapons
	const TYPE_AMMUNITION		= 3;	// Ammunition
	const TYPE_MINING_MODULE	= 4;	// Equipment
	const TYPE_CAPACITOR		= 10;
	const TYPE_PLATING			= 5;
	const TYPE_SHIELD			= 6;
	const TYPE_REACTOR			= 7;	// Engines
	const TYPE_DRIVE			= 8;
	const TYPE_INGREDIENT		= 9;	// Crafting items

	const DAMAGE_KINETIC		= 1;
	const DAMAGE_ENERGY			= 2;

	/**
	 * @var int
	 */
	private $techId;

	/**
	 * @var int
	 */
	private $amount;

	/**
	 * @var array
	 */
	private $techData;


	/**
	 * @param	Account	$account
	 * @param	int		$techId
	 * @param	int		$amount
	 */
	public function __construct(Account $account, $techId, $amount = 0) {
		parent::__construct($account);

		$this->techId = (int)$techId;
		$this->amount = (int)$amount;

		$config = Config::getInstance()->technology();
		$this->techData = &$config->technology[$techId];
	}

	/*****************************************************
	 * Base data
	 ****************************************************/

	/**
	 * @return int
	 */
	public function id() {
		return $this->techId;
	}

	/**
	 * @return int
	 */
	public function type() {
		return $this->techData['type'];
	}

	/**
	 * @return string
	 */
	public function name() {
		return i18n(
			$this->nameRaw()
		);
	}

	/**
	 * @return string
	 */
	public function nameRaw() {
		return ('name' . $this->techData['name']);
	}

	/**
	 * @return string
	 */
	public function description() {
		return i18n('desc'.$this->techData['name']);
	}

	/**
	 * @return int
	 */
	public function level() {
		if (array_key_exists('level', $this->techData)) {
			return (int)$this->techData['level'];
		}

		return 0;
	}

	/**
	 * Current amount of items from this Technology.
	 *
	 * @return int
	 */
	public function amount() {
		return $this->amount;
	}

	/*****************************************************
	 * Amount modification
	 ****************************************************/

	/**
	 * @param	int		$amount
	 * @return	Technology
	 */
	public function add($amount) {
		$this->amount += $amount;

		return $this;
	}

	/**
	 * @param	int		$amount
	 * @return	Technology
	 * @throws	InvalidArgumentException
	 */
	public function sub($amount) {
		$amount = (int)$amount;
		if ($amount > $this->amount()) {
			$message = "Can't subtract {$amount} from {$this->amount()} items.";
			throw new InvalidArgumentException($message);
		}

		$this->amount -= $amount;

		return $this;
	}

	/*****************************************************
	 * Weight calculation
	 ****************************************************/

	/**
	 * Return the possible maximum weight a Technology can carry.
	 *
	 * @return	int
	 */
	public function tonnage() {
		if ($this->isStarship()) {
			return $this->techData['tonnage'];
		}

		return 0;
	}

	/**
	 * Return the weight of...
	 * 1. a single item (not stackable).
	 * 2. a single stack (stackable).
	 *
	 * @return int
	 */
	public function weight() {
		return (int)$this->techData['weight'];
	}

	/**
	 * Return the weight of all items (amount * weight).
	 *
	 * @param int $extraAmount
	 * @return int
	 */
	public function totalWeight($extraAmount = 0) {
		$amount = $extraAmount + $this->amount;
		if ($this->isStackable()) {
			$stackAmount = $this->stackAmount($extraAmount);
		} else {
			$stackAmount = $amount;
		}

		return ($stackAmount * $this->weight());
	}

	/*****************************************************
	 * Stackable items
	 ****************************************************/

	/**
	 * @return int
	 */
	public function stackSize() {
		if ($this->isStackable()) {
			return $this->techData['stack'];
		}

		return 1;
	}

	/**
	 * @param int $extraAmount
	 * @return float
	 */
	public function stackAmount($extraAmount = 0) {
		if ($this->isStackable()) {
			$amount = $extraAmount + $this->amount;
			return ceil($amount / $this->stackSize());
		}

		return 1;
	}

	/**
	 * @return int
	 */
	public function stackGap() {
		if ($this->isStackable()) {
			$fullStackAmount = $this->stackAmount() * $this->stackSize();
			return (int)($fullStackAmount - $this->amount());
		}

		return 0;
	}

	/**
	 * @return bool
	 */
	public function isStackable() {
		return isset($this->techData['stack']);
	}

	/*****************************************************
	 * Structural integrity and plating
	 ****************************************************/

	/**
	 * @return int
	 */
	public function structure() {
		if ($this->isStarship()) {
			return $this->techData['structure'];
		}

		return 0;
	}

	/**
	 * Return the armor of a single item.
	 *
	 * @return int
	 */
	public function armor() {
		if ($this->isPlating()) {
			return $this->techData['armor'];
		}

		return 0;
	}

	/**
	 * Return the armor of all items (amount * armor).
	 *
	 * @return int
	 */
	public function totalArmor() {
		if ($this->isPlating()) {
			return ($this->amount() * $this->armor());
		}

		return 0;
	}

	/*****************************************************
	 * Weapon damage and reload stuff
	 ****************************************************/

	/**
	 * @return int
	 */
	public function damage() {
		if ($this->isWeapon()) {
			return $this->techData['damage'];
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function reload() {
		if ($this->isWeapon()) {
			return $this->techData['reload'];
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function burst() {
		if (!$this->isWeapon()) {
			return 0;
		}

		if (isset($this->techData['burst'])) {
			return $this->techData['burst'];
		}

		return 1;
	}

	/**
	 * Return maximum possible damage in average per round.
	 * All fired rounds per burst multiplied with each damage
	 * divided by reload time.
	 *
	 * @return float|int
	 */
	public function damagePerRound() {
		if ($this->isWeapon()) {
			$fullDamage = $this->amount() * $this->damage() * $this->burst();
			return ($fullDamage / $this->reload());
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function damageType() {
		if ($this->isWeapon()) {
			return $this->techData['damageType'];
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function damageTypeName() {
		switch ($this->damageType()) {
			case self::DAMAGE_KINETIC:
				return i18n('kinetic');

			case self::DAMAGE_ENERGY:
				return i18n('energy');

			default:
				return '';
		}
	}

	/**
	 * @return null|Technology
	 */
	public function ammunition() {
		if ($this->isWeapon() && isset($this->techData['ammo'])) {
			return new Technology(
				$this->account(),
				$this->techData['ammo']
			);
		}

		return null;
	}

	/*****************************************************
	 * Shield data
	 ****************************************************/

	/**
	 * @return int
	 */
	public function shieldStrengthPerEnergy() {
		if ($this->isShield()) {
			return $this->techData['shield'];
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function shieldMaxStrength() {
		if ($this->isShield()) {
			return $this->shieldBuildUpDrain() * $this->shieldStrengthPerEnergy();
		}

		return 0;
	}

	/**
	 * @param int $damageType
	 * @return int
	 */
	public function shieldAbsorb($damageType) {
		if ($this->isShield()) {
			$absorb = $this->techData['absorb'];
			if (isset($absorb[$damageType])) {
				return $absorb[$damageType];
			}
		}

		return 0;
	}

	/*****************************************************
	 * Drive / Engines
	 ****************************************************/

	/**
	 * @return int
	 */
	public function starTourSeconds() {
		if ($this->isDrive()) {
			return $this->techData['seconds'];
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function thrust() {
		if (array_key_exists('thrust', $this->techData)) {
			return (int)$this->techData['thrust'];
		}

		return 0;
	}

	/*****************************************************
	 * Energy drain
	 ****************************************************/

	/**
	 * @return int
	 */
	public function drain() {
		if ($this->isWeapon()) {
			return $this->techData['drain'];
		}

		return 0;
	}

	/**
	 * Return average energy drain, while a burst only consumes
	 * one drain amount.
	 *
	 * @return float|int
	 */
	public function drainPerRound() {
		if ($this->isWeapon()) {
			$fullDrain = $this->amount() * $this->drain();
			return ($fullDrain / $this->reload());
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function shieldRechargeDrain() {
		if ($this->isShield()) {
			return $this->techData['recharge'];
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function shieldBuildUpDrain() {
		if ($this->isShield()) {
			return $this->techData['buildUp'];
		}

		return 0;
	}

	/*****************************************************
	 * Energy recharge
	 ****************************************************/

	/**
	 * @return int
	 */
	public function recharge() {
		if ($this->isReactor()) {
			return $this->techData['recharge'];
		}

		return 0;
	}

	/**
	 * Return average energy recharge. Recharge equals recharge per
	 * round.
	 *
	 * @return float|int
	 */
	public function rechargePerRound() {
		if ($this->isReactor()) {
			return ($this->amount() * $this->recharge());
		}

		return 0;
	}

	/*****************************************************
	 * Energy capacity
	 ****************************************************/

	/**
	 * Return the capacity of a single item.
	 *
	 * @return int
	 */
	public function capacity() {
		if (array_key_exists('capacity', $this->techData)) {
			return $this->techData['capacity'];
		}

		return 0;
	}

	/**
	 * Return the capacity of al items (amount * capacity).
	 *
	 * @TODO Add pure capacity items when invented...
	 *
	 * @return float|int
	 */
	public function totalCapacity() {
		return ($this->amount() * $this->capacity());
	}

	/*****************************************************
	 * Slots
	 ****************************************************/

	/**
	 * @param	string	$slotName
	 * @return	int
	 */
	public function slots($slotName) {
		if (isset($this->techData['slots'])) {
			return $this->techData['slots'][$slotName];
		}

		return 0;
	}

	/**
	 * @return int
	 */
	public function slotUsage() {
		if ($this->isStackable()) {
			return 1;
		}

		return $this->amount;
	}

	/**
	 * @return int
	 */
	public function ammunitionSlots() {
		return $this->slots('ammunition');
	}

	/**
	 * @return int
	 */
	public function weaponrySlots() {
		return $this->slots('weaponry');
	}

	/**
	 * @return int
	 */
	public function equipmentSlots() {
		return $this->slots('equipment');
	}

	/**
	 * @return int
	 */
	public function cargoSlots() {
		return $this->slots('cargo');
	}

	/**
	 * @return int
	 */
	public function engineSlots() {
		return $this->slots('engine');
	}

	/**
	 * @return string
	 */
	public function starshipSlot() {
		switch ($this->type()) {
			case self::TYPE_WEAPON:
				return techSelector::TYPE_WEAPONRY;

			case self::TYPE_AMMUNITION:
				return techSelector::TYPE_AMMUNITION;

			case self::TYPE_MINING_MODULE:
			case self::TYPE_CAPACITOR:
			case self::TYPE_PLATING:
			case self::TYPE_SHIELD:
				return techSelector::TYPE_EQUIPMENT;

			case self::TYPE_REACTOR:
			case self::TYPE_DRIVE:
				return techSelector::TYPE_ENGINE;

			case self::TYPE_INGREDIENT:
				return techSelector::TYPE_CARGO;

			default:
				return '';
		}
	}

	/*****************************************************
	 * Sizes
	 ****************************************************/

	/**
	 * @param float $value
	 * @return int
	 */
	private function roundToFive($value) {
		$value *= 100;
		return (int)(round($value / 5) * 5);
	}

	/**
	 * @return int
	 */
	public function size() {
		if ($this->isStarship()) {
			return
				$this->weaponrySlots() +
				$this->ammunitionSlots() +
				$this->equipmentSlots() +
				$this->cargoSlots() +
				$this->engineSlots();
		}

		return 0;
	}

	/**
	 * @return stdClass
	 */
	public function sizeConfig() {
		if (!$this->isStarship()) {
			return null;
		}

		$size = $this->size();

		$result = new stdClass();

		$result->cockpit = $this->roundToFive(
			$this->equipmentSlots() / $size
		);

		$result->weaponry = $this->roundToFive(
			$this->weaponrySlots() / $size
		);

		$result->body = $this->roundToFive(
			($this->ammunitionSlots() + $this->cargoSlots()) / $size
		);

		$result->engine =
			100 -
			($result->cockpit + $result->weaponry + $result->body);

		return $result;
	}

	/*****************************************************
	 * Technology types
	 ****************************************************/

	/**
	 * @return bool
	 */
	public function isStarship() {
		return (self::TYPE_STARSHIP === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isWeapon() {
		return (self::TYPE_WEAPON === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isAmmunition() {
		return (self::TYPE_AMMUNITION === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isMiningModule() {
		return (self::TYPE_MINING_MODULE === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isPlating() {
		return (self::TYPE_PLATING === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isShield() {
		return (self::TYPE_SHIELD === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isReactor() {
		return (self::TYPE_REACTOR === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isCapacitor() {
		return (self::TYPE_CAPACITOR === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isDrive() {
		return (self::TYPE_DRIVE === $this->type());
	}

	/**
	 * @return bool
	 */
	public function isIngredient() {
		return (self::TYPE_INGREDIENT === $this->type());
	}

	/**
	 * @return string
	 */
	public function typeName() {
		switch ($this->type()) {
			case self::TYPE_STARSHIP:
				return i18n('starship');

			case self::TYPE_WEAPON:
				return i18n('weaponry');

			case self::TYPE_AMMUNITION:
				return i18n('ammunition');

			case self::TYPE_MINING_MODULE:
				return i18n('miningModule');

			case self::TYPE_PLATING:
				return i18n('additionalArmor');

			case self::TYPE_SHIELD:
				return i18n('shieldPlus');

			case self::TYPE_REACTOR:
				return i18n('reactors');

			case self::TYPE_CAPACITOR:
				return i18n('capacitors');

			case self::TYPE_DRIVE:
				return i18n('drives');

			case self::TYPE_INGREDIENT:
				return i18n('ingredients');

			default:
				return 'unknown';
		}
	}

	/*****************************************************
	 * Item trading
	 ****************************************************/

	/**
	 * @return bool
	 */
	public function isShoppable() {
		return ($this->shopPrice() > 0);
	}

	/**
	 * @return int
	 */
	public function shopPrice() {
		if (array_key_exists('price', $this->techData)) {
			return (int)$this->techData['price'];
		}

		return 0;
	}

	/*****************************************************
	 * Item crafting
	 ****************************************************/

	/**
	 * @return bool
	 */
	public function isCraftable() {
		return array_key_exists('craft', $this->techData);
	}

	/**
	 * @return array of [*tech id* => *needed amount*]
	 */
	public function craftIngredients() {
		if ($this->isCraftable()) {
			return $this->techData['craft'];
		}

		return array();
	}

	/**
	 * @return bool
	 */
	public function receiveCraftHint() {
		if (array_key_exists('craftHint', $this->techData)) {
			return $this->techData['craftHint'];
		}

		return false;
	}

	/*****************************************************
	 * Raw data retrieval
	 ****************************************************/

	/**
	 * @param int $techId
	 * @return Technology
	 */
	public static function raw($techId) {
		static $technologies = array();

		if (!isset($technologies[$techId])) {
			$technologies[$techId] = new Technology(
				new Account(null),
				$techId
			);
		}

		return $technologies[$techId];
	}
}