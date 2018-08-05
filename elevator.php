<?php

require_once "config.php";
require_once "base_elevator_msg.php";

class Elevator extends Base_Elevator_MSG {
	private $isStop = false;
	private $duration = null;
	private $elevatorUsers = [];
	protected $currentFloor = Config::ELEVATOR_FLOOR_START;
	protected $toFloor;

	function addElevatorUser(Elevator_User $elevatorUser) {
		$this->elevatorUsers[] = $elevatorUser;
	}

	function removeElevatorUser($userIndex)
	{
		unset($this->elevatorUsers[$userIndex]);
	}

	function isStop() : bool {
		return $this->isStop;
	}

	function setIsStop() {
		return $this->isStop;
	}

	private function speed() : float {
		return Config::FLOOR_HEIGHT / Config::ELEVATOR_SPEED;
	}

	private function callElevator(&$defaultUsers) {
		$user = current($defaultUsers);
		$this->duration = null;

		if ($this->currentFloor != $user->getFromFloor()) {
			$this->toFloor = $user->getFromFloor();
			$this->moveToMsg();
		
			while($this->currentFloor != $user->getFromFloor()) {
				$this->currentFloor > $user->getFromFloor() ? $this->currentFloor-- : $this->currentFloor++;
				sleep($this->speed());
				$this->currentFloorMsg();
			}
		}
	}

	private function collectUsersFromCurrentFloor(&$defaultUsers) {
		foreach ($defaultUsers as $key => $user) {
			if ($user->getFromFloor() == $this->currentFloor &&  ($user->getDuration() == $this->duration || empty($this->duration))) {
				$this->addElevatorUser($user);
				$this->toFloor = $user->getToFloor();
				$this->duration = $user->getDuration();
				$this->comeInUserMsg($user);

				unset($defaultUsers[$key]);
			}	
		}
	}

	private function checkOnExit() : bool {
		foreach ($this->elevatorUsers as $key => $user) {
			if ($user->getToFloor() == $this->currentFloor) {
				return true;
			}
		}
		return false;
	}

	private function exitOnTheFloor() {
		foreach ($this->elevatorUsers as $key => $user) {
			if ($user->getToFloor() == $this->currentFloor) {
				$this->comeOutUserMsg($user);
				$this->removeElevatorUser($key);
			}
		}
	}

	function run(array $defaultUsers) {
		$operationLimit = 10;

		while (!empty($defaultUsers) || !empty($this->elevatorUsers)) {
			if (--$operationLimit == 0) {
				break;
			}

			$this->callElevator($defaultUsers);	
			$this->openDoorMsg();			
			$this->collectUsersFromCurrentFloor($defaultUsers);
			$this->closeDoorMsg();
			$this->moveToMsg();

			while ($this->currentFloor > $this->toFloor || $this->currentFloor < $this->toFloor) {
				$this->currentFloor < $this->toFloor ? $this->currentFloor++ : $this->currentFloor--;
				sleep($this->speed());
				$this->currentFloorMsg();

				if ($this->checkOnExit()) {
					$this->openDoorMsg();
					$this->exitOnTheFloor();
					$this->closeDoorMsg();
				}

				$this->collectUsersFromCurrentFloor($defaultUsers);
			}
		}

		if (empty($defaultUsers) && empty($this->elevatorUsers)) {
			$this->endMsg();
			return true;
		} 
		else {
			return false;
		}
	}
}