<?php
/**
 * Handles event box appearance.
 */
class EventBox {
	/**
	 * @var bool
	 */
	private $success = true;

	/**
	 * @var string
	 */
	private $headline = '';

	/**
	 * @var string
	 */
	private $message = '';

	/**
	 * @var bool
	 */
	private $locked = false;

	/**
	 * Singleton (important).
	 * There can be only one event at a time.
	 *
	 * @return eventBox
	 */
	public static function get() {
		return Lisbeth_ObjectPool::get('eventBox');
	}

	/**
	 * @param string $headline
	 * @return eventBox
	 */
	public function headline($headline) {
		$this->headline = $headline;

		return $this;
	}

	/**
	 * @param string $message
	 * @return eventBox
	 */
	public function success($message) {
		if (!$this->locked) {
			$this->success = true;
			$this->message = $message;
		}

		return $this;
	}

	/**
	 * @param string $message
	 * @return eventBox
	 */
	public function failure($message) {
		if (!$this->locked) {
			$this->success = false;
			$this->message = $message;
		}

		return $this;
	}

	/**
	 * @return eventBox
	 */
	public function lock() {
		$this->locked = true;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasMessage() {
		return !empty($this->message);
	}

	/**
	 * @return string
	 */
	public function javaScript() {
		return $this->hasMessage()
			? "$('.eventBox').eventBox();"
			: '';
	}

	/**
	 * @return string
	 */
	public function toHtml() {
		$style = $this->success
			? 'success'
			: 'failure';

		$message = $this->message;
		if ($this->headline) {
			$message = "<span class='headline'>{$this->headline}</span><br>".$message;
			$style .= ' combined';
		}

		return $this->hasMessage()
			? "<div class='eventBox {$style}'>{$message}</div>"
			: '';
	}
}