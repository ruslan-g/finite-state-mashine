# Finite State Machine

Welcome to the project!
This is a minimalistic finite state machine written in PHP

## Installation
* Get the latest version of Docker community version
* Clone the project (copy the following script and paste it in your terminal):
```git clone https://github.com/ruslan-g/finite-state-mashine finite-state-mashine \
   && cd ./finite-state-mashine
```
* Start the docker containers from the project folder
```bash
docker-compose up
```
* Install dependencies
```
docker exec fsm composer install
```
* Run composer install

## How to create state machine

```php
use FSM\State\StateInterface;
use FSM\Transition\Transition;
use FSM\State\State;
use FSM\StateMachine\StateMachine;
use FSM\Exception\InvalidInputException;

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

try {
	printf("The result is: %s\n", $sm->run('110'));

} catch (InvalidInputException $exception) {
	echo $exception->getMessage() . "\n";
}
```

## How to run an examples
```
docker exec fsm php example.php
docker exec fsm php example.php
```
## How to run unit test
```
docker exec fsm vendor/bin/phpunit tests/FSM/Test/StateMachineTest.php
```