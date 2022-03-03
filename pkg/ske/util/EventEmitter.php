<?php namespace Ske\Util;

trait EventEmitter {
    protected array $eventListeners = [];

	public function todo(): array {
		return $this->eventListeners;
	}

    public function on(string $event, callable $eventListener): self {
        if (!isset($this->eventListeners[$event])) {
            $this->eventListeners[$event] = [];
        }
        $this->eventListeners[$event][] = $eventListener;
        return $this;
    }

    public function undo(string $event, callable $eventListener): self {
        if (!isset($this->eventListeners[$event])) {
            return $this;
        }

        if (false === ($key = array_search($eventListener, $this->eventListeners[$event]))) {
            return $this;
        }

        array_splice($this->eventListeners[$event], $key, 1);
        return $this;
    }

    protected array $eventsListened = [];

    public function do(string $event, mixed ...$data): self {
        if (!isset($this->eventListeners[$event])) {
            return $this;
        }

        foreach ($this->eventListeners[$event] as $key => $eventListener) {
            $this->eventsListened[$event][$key][] = $eventListener(...$data);
        }

        return $this;
    }

    public function done(?string $event = null): array {
        return $event ? ($this->eventsListened[$event] ?? []) : $this->eventsListened;
    }
}
