<?php

class Controller_Index extends Controller_Base
{
	public $page;

	/**
	 * Preprocessing
	 */
	public function before() {
		// Set fields handled in input form as array
		parent::before();
	}

	/**
	 *
	 * @throws Exception
	 */
	public function action_index()
	{
		if (Auth::check())
		{
			Auth::member(\Constants::$user_group['Administrators']) and \Response::redirect('admin/projects');
			Auth::member(\Constants::$user_group['Moderators']) and \Response::redirect('moderator/projects');
			Auth::member(\Constants::$user_group['Users']) and \Response::redirect('user/projects');

			\Auth::logout();
		}

		Response::redirect('login');
	}
}