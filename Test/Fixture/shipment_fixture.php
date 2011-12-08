<?php

class ShipmentFixture extends CakeTestFixture
{
	var $name = 'Shipment';

	var $fields = array(
		'id'		=> array('type' => 'integer', 'key' => 'primary'),
		'ship_date'	=> array('type' => 'date'),
		'order_item_id'	=> array('type' => 'integer')
	);

	var $records = array(
		array ('id' => 320, 'ship_date' => '2011-01-07', 'order_item_id' => 50),
		array ('id' => 319, 'ship_date' => '2011-01-07', 'order_item_id' => 50),
		array ('id' => 310, 'ship_date' => '2011-01-07', 'order_item_id' => 50)
	);
}
