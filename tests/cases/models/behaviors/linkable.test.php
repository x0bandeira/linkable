<?php

App::import('Model', 'Model');
App::import('Controller', 'Controller');

class TestModel extends CakeTestModel
{
	public $actsAs	= array(
		'Containable',
		'Linkable.Linkable'
	);
}

class User extends TestModel
{
	public $name = 'User';
	public $useDbConfig	= 'test_suite';

	public $hasOne	= array(
		'Profile'
	);
}

class Profile extends TestModel
{
	public $name = 'Profile';
	public $useDbConfig	= 'test_suite';
	
	public $belongsTo	= array(
		'User'
	);
}

class LinkableTestCase extends CakeTestCase
{
	public $fixtures	= array(
		'plugin.linkable.user',
		'plugin.linkable.profile'
	);
	
	public $Post;
	
	public function startTest()
	{
		$this->User	=& ClassRegistry::init('User');
	}
		
	public function testBelongsTo()
	{
		$arrayExpected	= array(
			'User'	=> array('id' => 1, 'username' => 'CakePHP'),
			'Profile'	=> array ('id' => 1, 'user_id' => 1, 'biography' => 'CakePHP is a rapid development framework for PHP that provides an extensible architecture for developing, maintaining, and deploying applications.')
		);

		$arrayResult	= $this->User->find('first');
		$this->assertTrue(isset($arrayResult['Profile']), 'Association via Containable: %s');
		$this->assertEqual($arrayResult, $arrayExpected, 'Association via Containable: %s');

		$arrayResult	= $this->User->find('first', array(
			'fields'	=> array(
				'id',
				'username'
			),
			'contain'	=> false,
			'link'		=> array(
				'Profile'	=> array(
					'fields'	=> array(
						'id',
						'user_id',
						'biography'
					)
				)
			)
		));

		// Same association, but this time with Linkable
		$this->assertTrue(isset($arrayResult['Profile']), 'Association via Linkable: %s');
		$this->assertEqual($arrayResult, $arrayExpected, 'Association via Linkable: %s');
		
		$arrayResult	= $this->User->find('first', array(
			'contain'	=> false,
			'link'		=> array(
				'Profile'
			)
		));

		$this->assertTrue(isset($arrayResult['Profile']), 'Association via Linkable (automatic fields): %s');
		$this->assertEqual($arrayResult, $arrayExpected, 'Association via Linkable (automatic fields): %s');

		// No field list for primary model
		$arrayExpected	= array(
			'User'	=> array('id' => 1, 'username' => 'CakePHP'),
			'Profile'	=> array ('biography' => 'CakePHP is a rapid development framework for PHP that provides an extensible architecture for developing, maintaining, and deploying applications.')
		);

		$arrayResult	= $this->User->find('first', array(
			'contain'	=> false,
			'link'		=> array(
				'Profile'	=> array(
					'fields'	=> array(
						'biography'
					)
				)
			)
		));

		$this->assertTrue(isset($arrayResult['Profile']), 'Association via Linkable (no primary fields): %s');
		$this->assertEqual($arrayResult, $arrayExpected, 'Association via Linkable (no primary fields): %s');
	}
	
	public function testPagination()
	{
		$objController	= new Controller();
		$objController->uses	= array('User');
		$objController->constructClasses();
		$objController->params['url']['url']	= '/';
		
		$objController->paginate	= array(
			'fields'	=> array(
				'username'
			),
			'contain'	=> false,
			'link'		=> array(
				'Profile'	=> array(
					'fields'	=> array(
						'biography'
					)
				)
			),
			'limit'		=> 2
		);
		
		$arrayResult	= $objController->paginate('User');

		$this->assertEqual($objController->params['paging']['User']['count'], 4, 'Paging: total records count: %s');

		// Pagination with order on a row from table joined with Linkable
		$objController->paginate	= array(
			'fields'	=> array(
				'id'
			),
			'contain'	=> false,
			'link'		=> array(
				'Profile'	=> array(
					'fields'	=> array(
						'user_id'
					)
				)
			),
			'limit'		=> 2,
			'order'		=> 'Profile.user_id DESC'
		);

		$arrayResult	= $objController->paginate('User');

		$arrayExpected	= array(
			0	=> array(
				'User'	=> array(
					'id' => 4
				),
				'Profile'	=> array ('user_id'	=> 4)
			),
			1	=> array(
				'User'	=> array(
					'id' => 3
				),
				'Profile'	=> array ('user_id'	=> 3)
			)
		);

		$this->assertEqual($arrayResult, $arrayExpected, 'Paging with order on join table row: %s');
	}
}