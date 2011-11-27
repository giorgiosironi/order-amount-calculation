<?php

namespace Slam;

class Order
{
	private $state;

	private $totalAmount;

	private $products;

	public function __construct()
	{
		$this->state = new OrderStatusPending();
	}

	public function setProducts(array $products = array())
	{
		$this->products = $products;
	}

	public function getTotalAmount()
	{
		// IMHO, this smells!
		if (! $this->state->isConfirmed()) {
			return $this->calcTotalAmount();
		}

		return $this->totalAmount;
	}

	private function calcTotalAmount()
	{
		/**
		 * This part is currently much more complex
		 * and involves lot of dependancies, like
		 * 	- User type
		 *	- Shipping address
		 *	- Current special offers
		 */

		$total = 0;
		foreach ($this->products as $product) {
			$total += $product->getPrice();
		}

		return $total;
	}

	public function confirm()
	{
		$this->state = new OrderStatusConfirmed();
		$this->totalAmount = $this->calcTotalAmount();
	}
}
