<?php

require_once "base_elevator.php";

class Base_Elevator_MSG extends Base_Elevator{
	function comeInUserMsg(Elevator_User $elevatorUser) {
		$this->setLog("Picked up " . $elevatorUser->getUserName() .
			" on the " . $elevatorUser->getFromFloor() . " floor," .
			" accepted the command to go " . $elevatorUser->getToFloor() . " floor");
	}

	function comeOutUserMsg(Elevator_User $elevatorUser) {
		$this->setLog("Dropped a " . $elevatorUser->getUserName() .
			" on the " . $elevatorUser->getToFloor() . " floor,");
	}

	function openDoorMsg() {
		$this->setLog("Door opening...");
	}

	function closeDoorMsg() {
		$this->setLog("Door closing...");
	}

	function currentFloorMsg() {
		$this->setLog("Now floor is " . $this->currentFloor);
	}

	function moveToMsg() {
		$this->setLog("Moving to " . $this->toFloor . " floor");
	}

	function endMsg() {
		$this->setLog("Those who want to ride have ended");
	}
}