<?php

class Model_Measuring_Point extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'project_id',
		'name',
		'location',
		'x_coordinate',
		'y_coordinate',
		'road_height',
		'account',
		'battery',
		'is_request',
		'note',
		'created_at',
		'updated_at',
		'deleted_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'measuring_points';

}
