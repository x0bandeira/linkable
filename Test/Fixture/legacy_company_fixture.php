<?php

class LegacyCompanyFixture extends CakeTestFixture
{
	var $name = 'LegacyCompany';

	var $fields = array(
		'company_id'		=> array('type' => 'integer', 'key' => 'primary'),
		'company_name'		=> array('type' => 'string', 'length' => 255, 'null' => false),
	);

	var $records = array(
		array('company_id' => 1, 'company_name' => 'Vintage Stuff Manufactory'),
		array('company_id' => 2, 'company_name' => 'Modern Steam Cars Inc.'),
		array('company_id' => 3, 'company_name' => 'Joe & Co Crate Shipping Company')
	);
}
