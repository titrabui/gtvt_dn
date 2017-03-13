<?php
class Controller_Logout extends Controller
{
		/**
	 * The logout function
	 *
	 * @access  public
	 * @return  none
	 */
    public function action_index()
    {
        // Object generation for login
        $auth = Auth::instance();
        $auth->logout();
        Response::redirect('/');
    }
}