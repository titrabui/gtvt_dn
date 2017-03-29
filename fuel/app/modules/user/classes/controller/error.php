<?php

namespace User;

class Controller_Error extends Controller_Base {

	public function before()
	{
		parent::before();

	}

	/**
	 * The index action.
	 * @access  public
	 * @return  void
	 */
	public function action_index()
	{
		\Session::get_flash('error') or \Response::redirect("user/projects");
		$this->template->content = \View::forge('error/index.php');
	}
}

/* End of file error.php */
