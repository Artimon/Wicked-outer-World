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
	 * @param $type
	 * @return Action_Academy_Training_Abstract|null
	 */
	public function actionAcademyTraining($type) {
		$account = $this->account();

		switch ($type) {
			case 'tactics':
				return new Action_Academy_Training_Tactics($account);

			case 'defense':
				return new Action_Academy_Training_Defense($account);

			case 'crafting':
				return new Action_Academy_Training_Crafting($account);

			default:
				return null;
		}
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
