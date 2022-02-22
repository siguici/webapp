<?php namespace Ske\Util;

class Result {
	public function __construct(int $status, string $message = '') {
		$this->setStatus($status);
		$this->setMessage($message);
	}

	protected int $status;

	public function setStatus(int $status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}

	protected string $message;

	public function setMessage(string $message) {
		$this->message = $message;
	}

	public function getMessage() {
		return $this->message;
	}

	public function isSuccess() {
		return 0 === $this->status;
	}

	public function isFailure() {
		return !$this->isSuccess();
	}

	public function isError() {
		return 1 === $this->status;
	}

	public function isWarning() {
		return 2 === $this->status;
	}

	public function isInfo() {
		return 3 === $this->status;
	}

	public function isDebug() {
		return 4 === $this->status;
	}

	public function isTrace() {
		return 5 === $this->status;
	}

	public function isFatal() {
		return 6 === $this->status;
	}

	public function isUnknown() {
		return 7 === $this->status;
	}

	public function isException() {
		return 8 === $this->status;
	}

	public function __toString() {
		return $this->getMessage();
	}
}
