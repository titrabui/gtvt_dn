<?php

class Model_Measuring_Value extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'measuring_point_id',
		'total_time_surveying',
		'weather',
		'value1',
		'value2',
		'value3',
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

	protected static $_table_name = 'measuring_values';

}
