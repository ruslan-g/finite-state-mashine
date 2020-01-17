<?php

require_once __DIR__ . '/vendor/autoload.php';

use FSM\State\StateInterface;
use FSM\Transition\Transition;
use FSM\State\State;
use FSM\StateMachine\StateMachine;

// create finite state machine to calculate remainder when dividing a number by 3

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

// Example of running step by step
$input = '110';

for($i = 0; $i < strlen($input); $i++) {

	$state = $sm->runStepByStep($input[$i]);
	printf("Input %s, Current state: %s\n", $input[$i], $state->getIdentifier());
}

if ($state->isFinal()) {
	echo 'State is final, the output is ' . $state->getOutput() . "\n";
} else {
	echo 'invalid input';
}