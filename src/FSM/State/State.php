<?php

namespace FSM\State;

class State implements StateInterface {

	/**
	 * @var string
	 */
	protected $identifier;

	/**
	 * @var @array
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $output;

	/**
	 * State constructor.
	 *
	 * @param $identifier
	 * @param $type
	 * @param $output
	 */
	public function __construct($identifier, $type, $output = null) {

		$this->identifier = $identifier;

		if (!is_array($type)) {
			$type = [$type];
		}

		$this->validateType($type);

		$this->type = $type;
		$this->output = $output;
	}

	/**
	 * @return bool
	 */
	public function isFinal(): bool {

		foreach ($this->type as $type) {

			if ($type === self::STATE_FINAL) {

				return true;
			}
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function isInitial(): bool {

		foreach ($this->type as $type) {

			if ($type === self::STATE_INITIAL) {

				return true;
			}
		}

		return false;
	}

	public function getIdentifier(): string {

		return $this->identifier;
	}

	/**
	 * @return string|null
	 */
	public function getOutput(): string {

		return $this->output;
	}

	/**
	 * @param array $types
	 */
	private function validateType(array $types) {

		foreach ($types as $type) {

			if (!in_array($type, [self::STATE_INITIAL, self::STATE_FINAL], true) ) {

				throw new \RuntimeException('Type should be one of the following: ' . implode(',', [self::STATE_INITIAL, self::STATE_FINAL]));
			}
		}
	}
}