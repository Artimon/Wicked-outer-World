<?php

/**
 * Basic constructor and functions for techContainer subclasses.
 */
abstract class techContainerSubclass {
	/**
	 * @var techContainerAbstract
	 */
	private $techContainer;

	/**
	 * @param techContainerAbstract $techContainer
	 */
	public function __construct(techContainerAbstract $techContainer) {
		$this->techContainer = $techContainer;
	}

	/**
	 * @return techContainerAbstract
	 */
	public function techContainer() {
		return $this->techContainer;
	}
}