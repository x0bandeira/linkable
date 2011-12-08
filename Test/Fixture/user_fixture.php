<?php

class UserFixture extends CakeTestFixture
{
	var $name = 'User';
	 
	var $fields = array(
		'id'			=> array('type' => 'integer', 'key' => 'primary'),
		'username'	=> array('type' => 'string', 'length' => 255, 'null' => false)
	);
	
	var $records = array(
		array('id' => 1, 'username' => 'CakePHP'),
		array('id' => 2, 'username' => 'Zend'),
		array('id' => 3, 'username' => 'Symfony'),
		array('id' => 4, 'username' => 'CodeIgniter')
	);
}
