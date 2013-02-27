<?php

class AccountFactory extends AccountSubclass {
	/**
	 * @return ActionProfileHealthCare
	 */
	public function actionProfileHealthCare() {
		return ObjectPool::get()->actionProfileHealthCare($this->account());
	}

	/**
	 * @return ActionHangarMission
	 */
	public function actionHangarMission() {
		return ObjectPool::get()->actionHangarMission($this->account());
	}

	/**
	 * @return ActionAcademyCourse
	 */
	public function actionAcademyCourse() {
		return ObjectPool::get()->actionAcademyCourse($this->account());
	}

	/**
	 * @return ActionAcademyTraining
	 */
	public function actionAcademyTraining() {
		return ObjectPool::get()->actionAcademyTraining($this->account());
	}

	/**
	 * @return ActionHangarStarTrip
	 */
	public function actionHangarStarTrip() {
		return ObjectPool::get()->actionHangarStarTrip($this->account());
	}

	/**
	 * @return ActionSkirmishOpponents
	 */
	public function actionSkirmishOpponents() {
		return ObjectPool::get()->actionSkirmishOpponents($this->account());
	}
}
