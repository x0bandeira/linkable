# Linkable Plugin
CakePHP plugin, PHP 5

## Introduction ##

Linkable is a lightweight approach for data mining on deep relations between models. Joins tables based on model relations to easily enable right to left find operations.

## Requirements ##
- CakePHP 1.2.x or 1.3.x
- PHP 5

## Installation ##

1. [Download] the latest release for your version of CakePHP or clone the Github repository

2. Place the files in a directory called 'linkable' inside the *app/plugins* directory of your CakePHP project.

3. Add the LinkableBehavior to a model or your AppModel:

    var $actsAs = array('Linkable.Linkable');

## Usage ##

Use it as a option to a find call. For example, getting a Post record with their associated (belongsTo) author User record:

    $this->Post->find('first', array(
		'link'	=> array(
			'User'
		)
	));

This returns a Post record with it's associated User data. However, this isn't much different from what you can do Containable, and with the same amount of queries. Things start to change when linking hasMany or hasAndBelongsToMany associations.

Because Linkable uses joins instead of seperate queries to get associated models, it is possible to apply conditions that operate from right to left (Tag -> Post) on hasMany and hasAndBelongsToMany associations.

For example, finding all posts with a specific tag (hasAndBelongsToMany assocation):

    $this->Post->find('all', array(
		'conditions'	=> array(
			'Tag.name'	=> 'CakePHP'
		),
		'link'	=> array(
			'Tag'
		)
	));

But what if you would still like all associated tags for the posts, while still applying the condition from the previous example? Fortunately, Linkable works well together with Containable. This example also shows some of the options Linkable has:

    $this->Post->find('all', array(
		'conditions'	=> array(
			'TagFilter.name'	=> 'CakePHP'
		),
		'link'	=> array(
			'PostsTag'	=> array(
				'TagFilter'	=> array(
					'class'			=> 'Tag',
					'conditions'	=> 'TagFilter.id = PostsTag.tag_id',	// Join condition (LEFT JOIN x ON ...)
					'fields'		=> array(
						'TagFilter.id'
					)
				)
			)
		),
        'contain'	=> array(
			'Tag'
		)
	));

If you're thinking: yeesh, that is a lot of code, then I agree with you ;). Linkable's automagical handling of associations with non-standard names has room for improvement. Please, feel free to contribute to the project via GitHub.

### Pagination ###

As a last example, pagination. This will find and paginate all posts with the tag 'CakePHP':

    $this->paginate = array(
        'fields'    => array(
            'title'
        ),
        'conditions'	=> array(
			'Tag.name'	=> 'CakePHP'
		),
		'link'	=> array(
			'Tag'
		)
        'limit' => 10
    );

    $this->paginate('Post');

### Notes ##

When fetching data in right to left operations, meaning in "one to many" relations (hasMany, hasAndBelongsToMany), it should be used in the opposite direction ("many to one"), i.e:

To fetch all Users assigned to a Project:

    $this->Project->find('all', array('link' => 'User', 'conditions' => 'project_id = 1'));
This won't produce the desired result as only a single user will be returned.

    $this->User->find('all', array('link' => 'Project', 'conditions' => 'project_id = 1'));
This will fetch all users related to the specified project in one query.

## Authors ##
- Originally authored by: Rafael Bandeira (rafaelbandeira3 (at) gmail (dot) com), http://rafaelbandeira3.wordpress.com
- Maintained by: Arjen Verstoep (terr (at) terr (dot) nl), https://github.com/Terr
- giulianob, https://github.com/giulianob
- Chad Jablonski, https://github.com/cjab
- Nathan Porter, https://github.com/n8man

## License ##

Licensed under The MIT License
Redistributions of files must retain the above copyright notice.

[Download]: https://github.com/Terr/linkable/downloads
