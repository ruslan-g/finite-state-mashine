<?php

namespace FSM\Transition;

class Transition {

	private $from;

	private $to;

	private $parameter;

	/**
	 * @return mixed
	 */
	public function getFrom() {

		return $this->from;
	}

	/**
	 * @return mixed
	 */
	public function getTo() {

		return $this->to;
	}

	/**
	 * @return mixed
	 */
	public function getParameter() {

		return $this->parameter;
	}

	public function __construct($from, $to, $parameter) {

		$this->from = $from;
		$this->to = $to;
		$this->parameter = $parameter;
	}
}