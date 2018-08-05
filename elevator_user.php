<?php

class Elevator_User {
	private $userName;
	private $fromFloor;
	private $toFloor;
	private $useStop;

	function __construct(string $userName, int $fromFloor, int $toFloor, bool $useStop = false) {
		$this->userName = $userName;
		$this->fromFloor = $fromFloor;
		$this->toFloor = $toFloor;
		$this->useStop = $useStop;
	}

	function getUserName() : string {
		return $this->userName;
	}

	function getFromFloor() : int {
		return $this->fromFloor;
	}

	function getToFloor() : int {
		return $this->toFloor;
	}

	function getDuration() : string {
		return $currentUserDuration = $this->getFromFloor() < $this->getToFloor() ? 'up' : 'down';
	}

	function getUseStop() : bool {
		return $this->useStop;
	}
}