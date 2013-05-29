<?php

class RenderAcademyCourse extends RenderAcademyAbstract {
	protected function commitActions() {
		$request = Leviathan_Request::getInstance();
		$actionAcademyCourse = $this->account()->factory()->actionAcademyCourse();

		if ($request->post('startCourse')) {
			$actionAcademyCourse->start();
		}

		if ($request->post('getCertificate')) {
			$actionAcademyCourse->finish();
		}
	}

	public function bodyHtml() {
		$this->commitActions();

		$account = $this->account();
		$course = $account->factory()->actionAcademyCourse();

		$coursesHeadline = i18n('courses');
		$coursesText = i18n('coursesText');

		$courseLevel = i18n(
			'courseLevel',
			$account->academyCourseLevel()
		);

		$html = "
<h2>{$coursesHeadline}</h2>
<p>{$coursesText}</p>
<p class='bold highlight'>{$courseLevel}</p>";

		if ($course->hasLeisureTime()) {
			$startCourseText = i18n('startCourseText');
			$startCourse = i18n('startCourse');

			$priceTitle = i18n('price');
			$price = Format::money(
				$course->certificateCost()
			);

			$durationTitle = i18n('duration');
			$duration = Leviathan_Format::duration(
				$course->duration()
			);

			if (!$course->canAfford()) {
				$priceStyle = 'critical bold';
				$buttonClass = ' disabled';
			}
			else {
				$priceStyle = 'variable';
				$buttonClass = '';
			}

			$html .= "
<p>{$startCourseText}</p>
<p>
	{$priceTitle}: <span class='{$priceStyle}'>{$price}</span><br>
	{$durationTitle}: <span class='variable'>{$duration}</span>
</p>
<form action='' method='post'>
	<input type='submit' name='startCourse' value='{$startCourse}' class='button{$buttonClass}'>
</form>";
		}

		if ($course->hasFinishedCourse()) {
			$courseFinished = i18n('courseFinished');
			$collect = i18n('collect');

			$html .= "
<p>{$courseFinished}</p>
<form action='' method='post'>
	<input type='submit' name='getCertificate' value='{$collect}' class='button important'>
</form>";
		}

		if ($course->isTakingCourse()) {
			$takingCourse = i18n('takingCourse');
			$timeLeft = i18n('timeLeft');

			$duration = Leviathan_Format::duration(
				$course->timeLeft()
			);

			$html .= "
<p>
	{$takingCourse}<br>
	{$timeLeft}: <span class='variable'>{$duration}</span>
</p>";
		}

		return $html;
	}
}
