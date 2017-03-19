<?php
namespace Admin;

//class Controller_Base extends \Controller_Template
use Fuel\Core\Request;

class Controller_Base extends \Controller_Base
{
	// set template
	public $template = 'template';

	/**
	 * Preprocessing
	 */
	public function before() {
		parent::before();

		// Check here except for login processing part
		if ($this->controller !== 'index' or ! in_array($this->action, array('login', 'logout')))
		{
			if (\Auth::check())
			{
				// If you are not already logged in as an administrator user, go to the top
				$admin_group_id = \Constants::$user_group['Administrators'];
				if (! \Auth::member($admin_group_id))
				{
					\Auth::logout();
					\Response::redirect('admin/projects');
				}
			}
			else
			{
				\Response::redirect('login');
			}
		}
	}

	/**
	 * Check CSRF token
	 */
	protected function _check_token() {
		if (!\Security::check_token()) {
			\Session::set_flash('error', \Constants::$error_message['expired_csrf_token']);
			\Response::redirect('login');
		}
	}
}
