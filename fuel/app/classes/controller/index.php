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
	public function action_index() {

		\Response::redirect('user/dashboard/index');

	}

}