<?php

interface techContainerInterface {
	/**
	 * Return the container's weight plus its payload.
	 *
	 * @abstract
	 * @return int
	 */
	public function weight();

	/**
	 * Return summed up weight of all contained items.
	 *
	 * @abstract
	 * @return int
	 */
	public function payload();

	/**
	 * Return the max weight the container can carry.
	 *
	 * @abstract
	 * @return int
	 */
	public function tonnage();

	/**
	 * @abstract
	 * @param string $type
	 * @return techGroup
	 */
	public function groupByName($type);

	/**
	 * @abstract
	 * @param technology $item
	 * @return techGroup
	 */
	public function groupByItem(technology $item);

	/**
	 * @abstract
	 * @param technology $item
	 * @return int
	 */
	public function loadableAmount(technology $item);
}