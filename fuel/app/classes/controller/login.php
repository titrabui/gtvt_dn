<?php

class Controller_Login extends Controller_Base
{
	/**
	 * Preprocessing
	 */
	public function before() {
		// Set fields handled in input form as array
		parent::before();

	}

	/**
	 * The login function
	 *
	 * @access  public
	 * @return  Response view
	 */
	public function action_index()
	{
		// Redirect to the page after login if already logged in
		\Auth::check() and \Response::redirect('/');

		// Acquire validate rule for login
		$val = \Model_User::validate('MasterLogin');

		if (\Input::method() == 'POST')
		{
			if ($val->run())
			{
				//Validate No problem
				if ( ! \Auth::check()) // Check if you are already logged in
				{
					if (\Auth::login(\Input::post('username'), \Input::post('password'))) //Login check
					{
						\Auth::member(\Constants::$user_group['Administrators']) and \Response::redirect('admin/projects/index');
						\Auth::member(\Constants::$user_group['Moderators']) and \Response::redirect('moderator/projects/index');
						\Auth::member(\Constants::$user_group['Users']) and \Response::redirect('user/projects/index');
							
						\Auth::logout();
						\Response::redirect('login/index');
					}
					else
					{
						// Set error message to view
						\Session::set_flash('error', \Constants::$error_message['login_error']);
					}
				}
				else
				{
					// Set error message to view
					\Session::set_flash('error', \Constants::$error_message['already_logged_in']);
				}
			}
		}

		// Call view template
		$view = View::forge('login/index');

		return $view;
	}
}