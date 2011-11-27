<?php

namespace Slam;

class OrderTest extends \PHPUnit_Framework_TestCase
{
	public function testOrderTotalHaveToChangeBeforeConfirm()
	{
		// The user joins the site
		$order = new Order();

		// Now the user adds, removes, changes and changes again the cart
		foreach ($this->customDataProvider() as $data) {
			$order->setProducts($data[0]);

			// But we need to give the preview of the total everytime
			$this->assertEquals($data[1], $order->getTotalAmount());
		}
	}

	public function testOrderConfirmedDoesntChangeTheTotalAmount()
	{
		$order = new Order();
		$products = array(
			new Product(15),
			new Product(25),
		);
		$total = 40;
		$order->setProducts($products);

		$this->assertEquals($total, $order->getTotalAmount());

		// Finally, the user confirms the order	
		$order->confirm();

		// And now we cannot change the order anymore
		// (an Exception should be raised, but that's not the point)
		foreach ($this->customDataProvider() as $data) {
			$order->setProducts($data[0]);
			$this->assertEquals($total, $order->getTotalAmount());
		}
	}

	public function customDataProvider()
	{
		return array(
			array(array(new Product(10), new Product(20)), 30),
			array(array(), 0),
			array(array(new Product(5)), 5),
		);
	}
}
