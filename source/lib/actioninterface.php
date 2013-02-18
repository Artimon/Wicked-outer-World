<?php

interface ActionInterface {
	/**
	 * @return bool
	 */
	public function canStart();

	public function start();
}
