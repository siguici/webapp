<?php namespace Ske\Bundle;

class Server {
	public function __construct(array $items) {
		$this->setMenu($items);
	}
	
	protected array $items = [];
	
	public function setMenu(array $items): self {
		$this->items = [];
		foreach($items as $name => $item) {
			$this->addItem($name, $item);
		}
		return $this;
	}
	
	public function addItem(string $name, Item $item): self {
		$this->items[$name] = $item;
		return $this;
	}
	
	public function getItem(string $name): ?Item {
		return $this->items[$name] ?? null;
	}
	
	public function getMenu(): array {
		return $this->items;
	}
	
	public function serve(Order $order): Item {
		$items = $this->getMenu();
		$order->setItems($items);
		return $order->getItem();
	}
}