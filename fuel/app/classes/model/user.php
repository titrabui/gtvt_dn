<?php

class Model_User extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'username',
		'password',
		'group',
		'email',
		'last_login',
		'login_hash',
		'profile_fields',
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

	protected static $_table_name = 'users';

	public static function validate($factory , $param = array())
	{
		$val = Validation::forge($factory);
		switch ($factory) {
			case 'MasterLogin': // Administrator user login
				// Validate rule setting
				$val->add_field('username', 'username', 'required');
				$val->add_field('password', 'password', 'required');
				break;
			case 'MasterCreate': // Create an administrator user
				// Validate rule setting
				$val->add_field('username', 'username', 'required|max_length[50]');
				$val->add_field('password', 'password', 'required|max_length[255]');
				$val->add_field('email', 'email', 'required|valid_email|max_length[255]');
				$val->add_field('group', 'group', 'valid_string[numeric]');
				$val->add_field('fullname', 'fullname', 'max_length[256]');
				$val->add_field('phone', 'phone', 'valid_string[numeric]');
				$val->add_field('address', 'address', 'max_length[512]');
				break;
			case 'MasterModify': // Change administrator user
				$val->add_callable('Validate_user');
				$val->add('old_password', 'old_password')
						->add_rule('required_with', 'password')
						->add_rule('oldpasscheck', $param['username'])
						->add_rule('max_length',255);
				$val->add('password', 'password')
						->add_rule('required_with', 'old_password')
						->add_rule('valid_string',array('alpha','numeric'))
						->add_rule('match_value', \Input::post('password2'), true)
						->add_rule('max_length',255);
				$val->add('email', 'email')
						->add_rule('match_value', \Input::post('email2'), true)
						->add_rule('valid_email')
						->add_rule('max_length',255);
				$val->set_message('oldpasscheck', \Constants::$error_message['bad_old_password']);
				break;
			case 'UserLogin':
				$val->add_field('username', 'username', 'required');
				$val->add_field('password', 'password', 'required');
				break;

			case 'UserModifyMail':
				$val->add('email', 'email')
					->add_rule('match_value', \Input::post('email2'), true)
					->add_rule('valid_email')
					->add_rule('max_length',255);
				break;

			case 'UserModifyPass':
				$val->add_callable('Validate_user');
				$val->add('old_password', 'old_password')
					->add_rule('required_with', 'password')
					->add_rule('oldpasscheck', $param['username'])
					->add_rule('max_length',255);
				$val->add('password', 'password')
					->add_rule('required_with', 'old_password')
					->add_rule('valid_string',array('alpha','numeric'))
					->add_rule('match_value', \Input::post('password2'), true)
					->add_rule('max_length',255);
				$val->set_message('oldpasscheck', \Constants::$error_message['bad_old_password']);
				break;

			case 'ApiUserModifyPass':
				$val->add('old_password', 'old_password')
					->add_rule('required_with', 'password')
					->add_rule('max_length', 255);
				$val->add('password', 'password')
					->add_rule('required_with', 'old_password')
					->add_rule('valid_string', array('alpha','numeric'))
					->add_rule('match_value', \Input::post('password2'), true)
					->add_rule('max_length', 255);
				break;
			default:
				break;
		}

		return $val;
	}
}