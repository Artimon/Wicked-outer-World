<?php

/**
 * Basic constructor and functions for techContainer subclasses.
 */
abstract class techContainerSubclass {
	/**
	 * @var TechContainerAbstract
	 */
	private $techContainer;

	/**
	 * @param TechContainerAbstract $techContainer
	 */
	public function __construct(TechContainerAbstract $techContainer) {
		$this->techContainer = $techContainer;
	}

	/**
	 * @return TechContainerAbstract
	 */
	public function techContainer() {
		return $this->techContainer;
	}
}