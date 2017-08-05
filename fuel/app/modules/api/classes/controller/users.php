<?php
namespace Api;

class Controller_Users extends Controller_Base {

	public function before()
	{
		parent::before();
	}

	/**
	 * The get user post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_get($id = null)
	{
		if ( ! $current_user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');
		if ($current_user['group'] != \Constants::$user_group['Administrators'])
			return $this->error_response('Access denied for user');

		try
		{
			if (is_null($id))
			{
				$users = \Model_User::query()
					->select('id', 'username', 'group', 'email', 'profile_fields', 'last_login')
					->from_cache(false)
					->get();
			}
			else
			{
				if ( ! \Model_User::find($id))
					return $this->error_response("User #.$id. is not exist");

				$users = \Model_User::query()
					->select('id', 'username', 'group', 'email', 'profile_fields', 'last_login')
					->where('id', $id)
					->from_cache(false)
					->get();
			}
			
			return $this->success_response($users);
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}

	/**
	 * The user infor post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_infor()
	{
		if ( ! $current_user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');

		return $this->success_response($current_user);
	}

	/**
	 * The register post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_register()
	{
		if ( ! $user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');
		if ($user['group'] != \Constants::$user_group['Administrators'])
			return $this->error_response('Access denied for user');

		try
		{
			$val = \Model_User::validate('MasterCreate');
				if ( ! $val->run()) return $this->error_response($val->error());

			if (\Auth::create_user(
				\Input::post('username'),
				\Input::post('password'),
				\Input::post('email'),
				\Input::post('group') ? \Input::post('group') : 1,
				array(
					'fullname' => \Input::post('fullname') ? \Input::post('fullname') : '',
					'phone' => \Input::post('phone') ? \Input::post('phone') : '',
					'address' => \Input::post('address') ? \Input::post('address') : ''
				)
			))
			{
				return $this->success_response();
			}
			else
			{
				return $this->error_response('Create user failed');
			}
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}

	/**
	 * The change_password post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_change_password()
	{
		if ( ! $user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');

		try
		{
			$val = \Model_User::validate('ApiUserModifyPass');
				if ( ! $val->run()) return $this->error_response($val->error());

			if (\Input::post('old_password') == \Input::post('password'))
				return $this->error_response('new_password and old_password must be different');

			if (\Auth::validate_user($user['username'], \Input::post('old_password')))
			{
				if (\Auth::change_password(
					\Input::post('old_password'),
					\Input::post('password'),
					$user['username']))
				{
					return $this->success_response();
				}
				else
				{
					return $this->error_response('Change password failed');
				}
			}
			else
			{
				return $this->error_response('old_password is wrong');
			}
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}

	/**
	 * The delete post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_delete($id = null)
	{
		if ( ! $user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');
		if ($user['group'] != \Constants::$user_group['Administrators'])
			return $this->error_response('Access denied for user');

		try
		{
			if (is_null($id)) return $this->error_response('Request format is not valid');

			if ( ! $delete_user = \Model_User::find($id))
				return $this->error_response('User #'.$id.' is not exist');

			if ($delete_user['username'] == $user['username'])
				return $this->error_response('Could not deleted current user');

			if ( ! \Auth::delete_user($delete_user['username']))
				return $this->error_response('Could not deleted user');

			return $this->success_response();
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}
}
