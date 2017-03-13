<?php

class Controller_Login extends Controller
{
	/**
	 * The login function
	 *
	 * @access  public
	 * @return  Response view
	 */
	public function action_index()
	{
		// Redirect to the page after login if already logged in
		Auth::check() and Response::redirect('welcome');

		// Variable initialization for error message
		$error = null;

		// Object generation for login
		$auth = Auth::instance();

		// When the login button is pressed, check the user name and password
		if (Input::post())
		{
			if ($auth->login(Input::post('username'), Input::post('password')))
			{
				// Redirect to page after login success, login after login
				Response::redirect('welcome/');
			}
			else
			{
				// When login fails, error message creation
				$error = 'Đăng nhập thất bại';
			}
		}

		// Call view template
		$view = View::forge('login/index');

		// et error message to view
		$view->set('error', $error);

		return $view;
	}
}