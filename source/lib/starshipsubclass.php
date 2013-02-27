<?php

/**
 * Basic constructor and functions for starship subclasses.
 */
abstract class StarshipSubclass {
	/**
	 * @var Starship
	 */
	private $starship;

	/**
	 * Constructor
	 *
	 * @param Starship $starship
	 */
	public function __construct(Starship $starship) {
		$this->starship = $starship;
	}

	/**
	 * Return Starship.
	 *
	 * @return Starship
	 */
	public function starship() {
		return $this->starship;
	}
}