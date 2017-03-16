<?php
class Controller_Logout extends Controller
{
    /**
     * Preprocessing
     */
    public function before() {
        // Set fields handled in input form as array
        parent::before();

    }
    
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