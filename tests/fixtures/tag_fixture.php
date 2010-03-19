<?php

class TagFixture extends CakeTestFixture
{
	var $name = 'Tag';
	 
	var $fields = array(
		'id'		=> array('type' => 'integer', 'key' => 'primary'),
		'name'		=> array('type' => 'string', 'length' => 255, 'null' => false)
	);
	
	var $records = array(
		array ('id' => 1, 'name' => 'General'),
		array ('id' => 2, 'name' => 'Test I'),
		array ('id' => 3, 'name' => 'Test II'),
		array ('id' => 4, 'name' => 'Test III')
	);
}
