<?php

namespace FSM\StateMachine;

use FSM\Exception\InvalidInputException;
use FSM\Exception\NoInitialStateDefined;
use FSM\Exception\NoTransitionFound;
use FSM\Transition\Transition;
use FSM\State\State;

class StateMachine {

	/**
	 * @var $transitions Transition[]
	 */
	private $transitions;

	/**
	 * @var $states State[]
	 */
	private $states;

	/**
	 * @var State $currentState
	 */
	private $currentState;

	/**
	 * @param State $state
	 */
	public function  setState(State $state) {

		$this->states[] = $state;
	}

	/**
	 * @param Transition $transition
	 */
	public function setTransition(Transition $transition) {

		$this->transitions[] = $transition;
	}

	/**
	 * @param $input
	 * @return string|null
	 */
	public function run($input) {

		$input = (string) $input;
		$strLen = strlen($input);

		$state = null;

		for ($i = 0; $i < $strLen; $i++) {
			$state = $this->runStepByStep($input[$i]);
		}

		if ($state instanceof State && $state->isFinal()) {

			return (int) $state->getOutput();
		} else {
			throw new InvalidInputException('Invalid Input');
		}
	}

	/**
	 * @param $input
	 * @return State|null
	 */
	public function runStepByStep($input) {

		$currentState = $this->getCurrentState();
		$nextState = $this->getNextState($currentState, $input);
		$this->currentState = $nextState;
		return $nextState;
	}

	/**
	 * @return State
	 */
	private function getCurrentState() {

		if (!$this->currentState) {
			foreach ($this->states as $state) {

				if ($state->isInitial()) {
					$this->currentState = $state;
				}
			}

			if (!$this->currentState) {

				throw new NoInitialStateDefined('No initial state defined in state machine');
			}
		}

		return $this->currentState;
	}

	/**
	 * @param string $identifier
	 * @return State|null
	 */
	private function getStateByIdentifier(string $identifier): ?State {

		foreach ($this->states as $state) {

			if ($state->getIdentifier() == $identifier) {
				return $state;
			}
		}

		return null;
	}

	/**
	 * @param State $currentState
	 * @param $input
	 * @return State|null
	 */
	private function getNextState(State $currentState, $input): ?State {

		foreach ($this->transitions as $transition) {

			if ($transition->getFrom() === $currentState->getIdentifier() && $transition->getParameter() == $input) {

				return $this->getStateByIdentifier($transition->getTo());
			}
		}

		throw new NoTransitionFound(sprintf('No transition found for %s and input %s, please check transition definition', $currentState->getIdentifier(), $input));
	}
}