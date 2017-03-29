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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);

		$val->add_field('account', 'Account', 'max_length[512]');
		$val->add_field('battery', 'Battery', 'valid_string[numeric]|numeric_between[0,100]');

		if ($factory == 'Measuring_Point_Page')
		{
			$val->add_field('name', 'Tên điểm đo', 'required|max_length[256]');
			$val->add_field('location', 'Vị trí', 'required|max_length[256]');
			$val->add_field('x_coordinate', 'Tọa độ X', 'required|valid_string[numeric,dots]');
			$val->add_field('y_coordinate', 'Tọa độ Y', 'required|valid_string[numeric,dots]');
			$val->add_field('road_height', 'Độ cao đường', 'required|valid_string[numeric,dots]');
			$val->add_field('is_request', 'Is_request', 'valid_string[numeric]|numeric_between[0,1]');
			$val->add_field('note', 'Ghi chú', 'max_length[1000]');
		}

		return $val;
	}

	protected static $_table_name = 'measuring_points';

	protected static $_has_many = array('measuring_values' => array(
		'model_to'       => 'Model_Measuring_Value',
		'key_from'       => 'id',
		'key_to'         => 'measuring_point_id',
		//'cascade_save'   => true,
		'cascade_delete' => true,
	));
}
