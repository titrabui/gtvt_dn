<?php

class Model_Project extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'location',
		'investor',
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
		$val->add_field('name', 'Name', 'required|max_length[255]');
		$val->add_field('location', 'Location', 'required|max_length[255]');
		$val->add_field('investor', 'Investor', 'required|max_length[255]');
		$val->add_field('note', 'Note', 'max_length[1000]');

		return $val;
	}

	protected static $_table_name = 'projects';

	protected static $_has_many = array('measuring_points' => array(
		'model_to'       => 'Model_Measuring_Point',
		'key_from'       => 'id',
		'key_to'         => 'project_id',
		//'cascade_save'   => true,
		'cascade_delete' => true,
	));
}
