<?php
namespace Api;

require_once (APPPATH.'vendor'.DS.'jwt'.DS.'JWT.php');
use \Firebase\JWT\JWT;

class Controller_Login extends Controller_Base
{
	private $TWO_HOURS = 7200;
	private $TEN_SECONDS = 10;

	public function before()
	{
		parent::before();
	}

	/**
	 * The Login Authenication function
	 *
	 * @access  public
	 * @return  true: authenicate success | false: authenicate error
	 */
	public function post_index()
	{
		// Acquire validate rule for login
		$val = \Model_User::validate('MasterLogin');
		if ( ! $val->run()) return $this->error_response($val->error());

		if ($user = \Auth::validate_user(\Input::post('username'), \Input::post('password')))
		{
			$issue_time = time();
			$token = array(
				"iss" => 'http://sgtvt-bkdn.com',
				"aud" => 'titrabui',
				"iat" => $issue_time,
				"nbf" => $issue_time + $this->TEN_SECONDS,
				"exp" => $issue_time + ($this->TEN_SECONDS + $this->TWO_HOURS),
				"data" => [
					"id" => $user['id'],
					"username" => $user['username'],
					"password" => \Input::post('password')
				]
			);

			try
			{
				$jwt = JWT::encode($token, $this->key);
			}
			catch (\Exception $e)
			{
				return $this->error_response('User name or password is invalid. Login failed');
			}

			return $this->response(array(
				'status' => 'Success',
				'token'  => $jwt
			), 200);
		}
		else
		{
			return $this->error_response('User name or password wrong. Login failed');
		}
	}
}
