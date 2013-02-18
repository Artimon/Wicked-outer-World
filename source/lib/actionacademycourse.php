<?php

class ActionAcademyCourse extends ActionAbstract {
	/**
	 * @return int
	 */
	public function certificateCost() {
		$level = $this->account()->academyCourseLevel();

		return (2000 * pow(1.3, $level));
	}

	public function duration() {
		$level = $this->account()->academyCourseLevel();

		return (43200 * pow(1.3, $level));
	}

	/**
	 * @return int
	 */
	public function timeLeft() {
		return $this->isTakingCourse()
			? $this->courseTime() - TIME
			: 0;
	}

	/**
	 * @return int
	 */
	public function courseTime() {
		return $this->account()->academyCourseTime();
	}

	/**
	 * @return bool
	 */
	public function hasLeisureTime() {
		return ($this->courseTime() === 0);
	}

	/**
	 * @return bool
	 */
	public function hasFinishedCourse() {
		if ($this->hasLeisureTime()) {
			return false;
		}

		return ($this->courseTime() < TIME);
	}

	/**
	 * @return bool
	 */
	public function isTakingCourse() {
		if ($this->hasLeisureTime()) {
			return false;
		}

		return ($this->courseTime() >= TIME);
	}

	/**
	 * @return bool
	 */
	public function canAfford() {
		return $this->price()->canAfford();
	}

	/**
	 * @return Price
	 */
	public function price() {
		return $this->account()
			->price()
			->set($this->certificateCost());
	}

	/**
	 * @return bool
	 */
	public function canStart() {
		$finished = $this->hasLeisureTime();
		$canAfford = $this->canAfford();

		return ($finished && $canAfford);
	}

	public function start() {
		if (!$this->canStart()) {
			EventBox::get()->failure(
				i18n('cannotStartCourse')
			);

			return;
		}

		$this
			->price()
			->buy()
			->setValue('academyCourseTime', TIME + $this->duration())
			->update();

		EventBox::get()->success(
			i18n('courseStarted')
		);
	}

	public function finish() {
		if (!$this->hasFinishedCourse()) {
			EventBox::get()->failure(
				i18n('cannotFinishCourse')
			);

			return;
		}

		$this->account()
			->setValue('academyCourseTime', 0)
			->increment('academyCourseLevel', 1)
			->update();

		EventBox::get()->success(
			i18n('gotCourseCertificate')
		);
	}
}
