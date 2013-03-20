<?php

interface TechContainerInterface {
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
	 * @param Technology $item
	 * @return techGroup
	 */
	public function groupByItem(Technology $item);

	/**
	 * @abstract
	 * @param Technology $item
	 * @return int
	 */
	public function loadableAmount(Technology $item);
}