<?php

namespace FSM\State;

interface StateInterface {

	const STATE_INITIAL = 'initial';

	const STATE_FINAL = 'final';

	public function isFinal(): bool;

	public function isInitial(): bool;

	public function getIdentifier(): string;

	public function getOutput(): string;
}