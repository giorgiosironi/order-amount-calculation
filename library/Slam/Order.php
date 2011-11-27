<?php

namespace Slam;

interface Payable
{
	function calcTotalAmount();
}

/* I think an interesting exploration could be pushing the total into the status.  */
interface OrderStatus
{
	function confirm();
	function changedProducts(Payable $payable);
	function getTotalAmount();
}

class Order implements Payable
{
	private $state;

	private $products;

	public function __construct()
	{
		$this->state = new OrderStatusPending(0);
	}

	public function setProducts(array $products = array())
	{
		$this->products = $products;
		$this->state = $this->state->changedProducts($this);
		// OrderStatusPending returns a new instance of itself, with updated price
		// OrderStatusConfirmed throws an exception or just returns itself (your business rules decide)
	}

	public function getTotalAmount()
	{
		return $this->state->getTotalAmount();
	}

	/** This should be in an interface, let's say Payable */
	public function calcTotalAmount()
	{
		/**
		 * This part is currently much more complex
		 * and involves lot of dependancies, like
		 * 	- User type
		 *	- Shipping address
		 *	- Current special offers
	  	.. so I'm assuming it must stay here. That's why I pass the whole object instead of just $this->products to changedProducts()
		 */

		$total = 0;
		foreach ($this->products as $product) {
			$total += $product->getPrice();
		}

		return $total;
	}

	public function confirm()
	{
		$this->state = $this->state->confirm();
		// OrderStatusPending returns an OrderStatusConfirmed with the same total
		// OrderStatusConfirmed throws a SomeErrorException or just ignores the message (your business rules decide)
	}
}
