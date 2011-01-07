<?php

class OrderItemFixture extends CakeTestFixture
{
	var $name = 'OrderItem';

	var $fields = array(
		'id'		=> array('type' => 'integer', 'key' => 'primary'),
		'active_shipment_id'	=> array('type' => 'integer'),
	);

	var $records = array(
		array ('id' => 50, 'active_shipment_id' => 320)
	);
}
