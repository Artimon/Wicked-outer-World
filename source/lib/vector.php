<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pascal
 * Date: 18.04.12
 * Time: 12:27
 * To change this template use File | Settings | File Templates.
 */
class vector {
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
	 * @param vector $vector
	 * @return vector
	 */
	public function set(vector $vector) {
		$this->x = $vector->x;
		$this->y = $vector->y;

		return $this;
	}

	/**
	 * @param vector $vector
	 * @return vector
	 */
	public function add(vector $vector) {
		$this->x += $vector->x;
		$this->y += $vector->y;

		return $this;
	}

	/**
	 * @param vector $vector
	 * @return vector
	 */
	public function sub(vector $vector) {
		$this->x -= $vector->x;
		$this->y -= $vector->y;

		return $this;
	}

	/**
	 * @param vector $vector1
	 * @param vector $vector2
	 * @return vector
	 */
	public function diff(vector $vector1, vector $vector2) {
		$this->x = $vector1->x - $vector2->x;
		$this->y = $vector1->y - $vector2->y;

		return $this;
	}

	/**
	 * @param vector $vector
	 * @return vector
	 */
	public function multiply(vector $vector) {
		$this->x *= $vector->x;
		$this->y *= $vector->y;

		return $this;
	}

	/**
	 * @return vector
	 */
	public function length() {
		return sqrt($this->x * $this->x + $this->y * $this->y);
	}

	/**
	 * @return vector
	 */
	public function angle() {
		return -atan2($this->y, $this->x) * (180 / M_PI);
	}

	/**
	 * @return vector
	 */
	public function inverse() {
		$this->x *= -1;
		$this->y *= -1;

		return $this;
	}

	/**
	 * @param float $factor
	 * @return vector
	 */
	public function scale($factor) {
		$this->x *= $factor;
		$this->y *= $factor;

		return $this;
	}

	/**
	 * @param float $length
	 * @return vector
	 */
	public function normalize($length) {
		$this->scale($length / $this->length());

		return $this;
	}

	/**
	 * @param float $angle
	 * @return vector
	 */
	public function rotate($angle) {
		$temp = new vector();

		$angle *= M_PI / 180;
		$temp->x = $this->x * cos($angle) - $this->y * sin($angle);
		$temp->y = $this->y * cos($angle) + $this->x * sin($angle);

		$this->set($temp);

		return $this;
	}
}