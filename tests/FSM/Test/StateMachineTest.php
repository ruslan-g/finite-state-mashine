<?php

namespace FSM\Test;

use FSM\Exception\InvalidInputException;
use FSM\Exception\NoInitialStateDefined;
use FSM\Exception\NoTransitionFound;
use FSM\StateMachine\StateMachine;
use FSM\State\State;
use FSM\Transition\Transition;
use FSM\State\StateInterface;

class StateMachineTest extends \PHPUnit_Framework_TestCase {

	public function testThrowExceptionWithNoInput() {

		$stateMachine = new StateMachine();

		$this->setExpectedException(InvalidInputException::class);
		$stateMachine->run('');

	}

	public function testThrowExceptionWhenNoInitialStateDefined() {

		$sm = new StateMachine();

		$sm->setState(new State('S0', [StateInterface::STATE_FINAL], 0));

		$sm->setTransition(new Transition('S0', 'S0', 0));

		$this->setExpectedException(NoInitialStateDefined::class);

		$sm->run('11');

	}

	public function testThrowExceptionNoTransitionDefined() {

		$sm = new StateMachine();

		$sm->setState(new State('S0', [StateInterface::STATE_FINAL, StateInterface::STATE_INITIAL], 0));

		$sm->setTransition(new Transition('S0', 'S0', 0));

		$this->setExpectedException(NoTransitionFound::class);

		$sm->run('1');

	}

	public function testStateMachineWorksForDefinedWorkflow() {

		// define state machine to calculate remainder when dividing a number by 3 and test the output

		for ($i = 1; $i < 100; $i++) {
			$sm = $this->getStateMachineToCalculateRemainder();
			$this->assertSame($i % 3, $sm->run(decbin($i)));
		}

	}

	private function getStateMachineToCalculateRemainder() {

		$sm = new StateMachine();

		$sm->setState(new State('S0', [StateInterface::STATE_FINAL, StateInterface::STATE_INITIAL], 0));
		$sm->setState(new State('S1', StateInterface::STATE_FINAL, 1));
		$sm->setState(new State('S2', StateInterface::STATE_FINAL, 2));

		$sm->setTransition(new Transition('S0', 'S0', 0));
		$sm->setTransition(new Transition('S0', 'S1', 1));
		$sm->setTransition(new Transition('S1', 'S0', 1));
		$sm->setTransition(new Transition('S1', 'S2', 0));
		$sm->setTransition(new Transition('S2', 'S2', 1));
		$sm->setTransition(new Transition('S2', 'S1', 0));

		return $sm;
	}
}