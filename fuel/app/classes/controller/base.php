<?php

class Controller_Base extends \Fuel\Core\Controller_Template
{
	// Template name
	public $referrer;
	public $modules;
	public $controller;
	public $action;

	public function before()
	{
		$this->current_user = null;
		$this->userprofile = null;

		$this->set_init();

		// Confirm whether simpleauth driver is certified
		$driver = Auth::verified('simpleauth');
		$logined = 0;

		if (($id = Auth::get_user_id()) !== false)
		{
			$this->current_user = Model\Auth_User::find($id[1]);
		}

		if (\Auth::check())
		{
			$logined = 1;
		}

		// Set a global variable so views can use it
		// View::set_global('current_user', $this->current_user);
		Session::set('current_user', $this->current_user);
		View::set_global('current_userprofile', $this->userprofile);

/*		if ( ! $this->is_restful())
		{
			$this->template->logined_flag = $logined;

			// Also set it for view
			$this->template->title = \Constants::$site_title;
			$this->template->pagetitle = \Constants::$page_title['normal'];
		}*/
		return parent::before();
	}

	/**
	 * set init
	 */
	private function set_init() {
		$this->modules = Request::main()->module;
		$controller = strtolower(str_replace("Controller_", "", Request::main()->controller));
		$controller = str_replace($this->modules . "\\", "", $controller);
		$controller = str_replace("_", "/", $controller);
		$this->controller = $controller;
		$this->action = Request::main()->action;
		if (!empty($this->template) and !is_string($this->template)) {
			$this->template->modeuls = Request::main()->module;
			$this->template->controller = $controller;
			$this->template->action = Request::main()->action;
		}
	}

}
