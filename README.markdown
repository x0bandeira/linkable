### Linkable Plugin
CakePHP Plugin - PHP 5 only

LinkableBehavior
Light-weight approach for data mining on deep relations between models. 
Join tables based on model relations to easily enable right to left find operations.

Original behavior by rafaelbandeira3 on GitHub. Includes modifications from Terr, n8man, and Chad Jablonski
 
Licensed under The MIT License
Redistributions of files must retain the above copyright notice.
  
This version is maintaned by:
GiulianoB ( https://bitbucket.org/giulianob/linkable/ )

### version 1.1:
- Brought in improvements and test cases from Terr. However, THIS VERSION OF LINKABLE IS NOT DROP IN COMPATIBLE WITH Terr's VERSION!
- If fields aren't specified, will now return all columns of that model
- No need to specify the foreign key condition if a custom condition is given. Linkable will automatically include the foreign key relationship.
- Ability to specify the exact condition Linkable should use. This is usually required when doing on-the-fly joins since Linkable generally assumes a belongsTo relationship when no specific relationship is found and may produce invalid foreign key conditions. Example:

    $this->Post->find('first', array('link' => array('User' => array('conditions' => array('exactly' => 'User.last_post_id = Post.id')))))

- Linkable will no longer break queries that use SQL COUNTs

### Complex Example

Here's a complex example using both linkable and containable at the same time :)

Relationships involved:  
CasesRun is the HABTM table of TestRun <-> TestCases  
CasesRun belongsTo TestRun  
CasesRun belongsTo User  
CasesRun belongsTo TestCase  
TestCase belongsTo TestSuite  
TestSuite belongsTo TestHarness  
CasesRun HABTM Tags  

    $this->TestRun->CasesRun->find('all', array(	
    	'link' => array(
    		'User' => array('fields' => 'username'), 
    		'TestCase' => array('fields' => array('TestCase.automated', 'TestCase.name'),
    			'TestSuite' => array('fields' => array('TestSuite.name'), 
    				'TestHarness' => array('fields' => array('TestHarness.name'))
    			)
    		)
    	),
    	'conditions' => array('test_run_id' => $id),
    	'contain' => array(
    		'Tag'					
    	),
    	'fields' => array(
    		'CasesRun.id', 'CasesRun.state', 'CasesRun.modified', 'CasesRun.comments'
    	)
    ))

Output SQL:  

    SELECT `CasesRun`.`id`, `CasesRun`.`state`, `CasesRun`.`modified`, `CasesRun`.`comments`, `User`.`username`, `TestCase`.`automated`, `TestCase`.`name`, `TestSuite`.`name`, `TestHarness`.`name` FROM `cases_runs` AS `CasesRun` LEFT JOIN `users` AS `User` ON (`User`.`id` = `CasesRun`.`user_id`) LEFT JOIN `test_cases` AS `TestCase` ON (`TestCase`.`id` = `CasesRun`.`test_case_id`) LEFT JOIN `test_suites` AS `TestSuite` ON (`TestSuite`.`id` = `TestCase`.`test_suite_id`) LEFT JOIN `test_harnesses` AS `TestHarness` ON (`TestHarness`.`id` = `TestSuite`.`test_harness_id`) WHERE `test_run_id` = 32

    SELECT `Tag`.`id`, `Tag`.`name`, `CasesRunsTag`.`id`, `CasesRunsTag`.`cases_run_id`, `CasesRunsTag`.`tag_id` FROM `tags` AS `Tag` JOIN `cases_runs_tags` AS `CasesRunsTag` ON (`CasesRunsTag`.`cases_run_id` IN (345325, 345326, 345327, 345328) AND `CasesRunsTag`.`tag_id` = `Tag`.`id`) WHERE 1 = 1 

If you were to try this example with containable, you would find that it generates a lot of queries to fetch all of the data records. Linkable produces a single query with joins instead.

### More examples  
Look into the unit tests for some more ways of using Linkable
