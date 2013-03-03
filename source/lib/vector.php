<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pascal
 * Date: 18.04.12
 * Time: 12:27
 * To change this template use File | Settings | File Templates.
 */
class Vector {
	/**
	 * @var float
	 */
	public $x;

	/**
	 * @var float
	 */
	public $y;

	/**
	 * @param float $x
	 * @param float $y
	 */
	public function __construct($x = .0, $y = .0) {
		$this->x = (float)$x;
		$this->y = (float)$y;
	}

	/**
	 * @param Vector $vector
	 * @return Vector
	 */
	public function set(Vector $vector) {
		$this->x = $vector->x;
		$this->y = $vector->y;

		return $this;
	}

	/**
	 * @param Vector $vector
	 * @return Vector
	 */
	public function add(Vector $vector) {
		$this->x += $vector->x;
		$this->y += $vector->y;

		return $this;
	}

	/**
	 * @param Vector $vector
	 * @return Vector
	 */
	public function sub(Vector $vector) {
		$this->x -= $vector->x;
		$this->y -= $vector->y;

		return $this;
	}

	/**
	 * @param Vector $vector1
	 * @param Vector $vector2
	 * @return Vector
	 */
	public function diff(Vector $vector1, Vector $vector2) {
		$this->x = $vector1->x - $vector2->x;
		$this->y = $vector1->y - $vector2->y;

		return $this;
	}

	/**
	 * @param Vector $vector
	 * @return Vector
	 */
	public function multiply(Vector $vector) {
		$this->x *= $vector->x;
		$this->y *= $vector->y;

		return $this;
	}

	/**
	 * @return Vector
	 */
	public function length() {
		return sqrt($this->x * $this->x + $this->y * $this->y);
	}

	/**
	 * @return Vector
	 */
	public function angle() {
		return -atan2($this->y, $this->x) * (180 / M_PI);
	}

	/**
	 * @return Vector
	 */
	public function inverse() {
		$this->x *= -1;
		$this->y *= -1;

		return $this;
	}

	/**
	 * @param float $factor
	 * @return Vector
	 */
	public function scale($factor) {
		$this->x *= $factor;
		$this->y *= $factor;

		return $this;
	}

	/**
	 * @param float $length
	 * @return Vector
	 */
	public function normalize($length) {
		$this->scale($length / $this->length());

		return $this;
	}

	/**
	 * @param float $angle
	 * @return Vector
	 */
	public function rotate($angle) {
		$temp = new Vector();

		$angle *= M_PI / 180;
		$temp->x = $this->x * cos($angle) - $this->y * sin($angle);
		$temp->y = $this->y * cos($angle) + $this->x * sin($angle);

		$this->set($temp);

		return $this;
	}
}