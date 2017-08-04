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
		'measuring_time',
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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('measuring_point_id', 'Measuring_point_id', 'required|valid_string[numeric]');
		$val->add_field('value1', 'Value1', 'required|valid_string[numeric,dots]');
		$val->add_field('value2', 'Value2', 'required|valid_string[numeric,dots]');
		$val->add_field('value3', 'Value3', 'required|valid_string[numeric,dots]');
		$val->add_field('date', 'Measuring_date', 'required|valid_date');
		$val->add_field('time', 'Measuring_time', 'required|valid_date');

		return $val;
	}

	protected static $_table_name = 'measuring_values';

}
