<?php

/**
 * Basic constructor and functions for starship subclasses.
 */
abstract class starshipSubclass {
	/**
	 * @var starship
	 */
	private $starship;

	/**
	 * Constructor
	 *
	 * @param starship $starship
	 */
	public function __construct(starship $starship) {
		$this->starship = $starship;
	}

	/**
	 * Return starship.
	 *
	 * @return starship
	 */
	public function starship() {
		return $this->starship;
	}
}