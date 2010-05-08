<?php

class TagFixture extends CakeTestFixture
{
	var $name = 'Tag';

	var $fields = array(
		'id'		=> array('type' => 'integer', 'key' => 'primary'),
		'name'		=> array('type' => 'string', 'length' => 255, 'null' => false),
		'parent_id'		=> array('type' => 'integer')
	);

	var $records = array(
		array ('id' => 1, 'name' => 'General', 'parent_id' => null),
		array ('id' => 2, 'name' => 'Test I', 'parent_id' => 1),
		array ('id' => 3, 'name' => 'Test II', 'parent_id' => null),
		array ('id' => 4, 'name' => 'Test III', 'parent_id' => null)
	);
}
