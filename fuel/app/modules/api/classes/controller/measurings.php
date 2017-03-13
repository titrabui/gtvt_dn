<?php
namespace Api;

class Controller_Measurings extends \Controller_Rest
{
	// default format
    protected $format = 'json';

	public function get_list()
	{
		return $this->response(array(
			'foo' => \Input::get('foo'),
			'baz' => array(
				1, 50, 219
			),
			'empty' => null
		));
	}

	/**
	 * The measuring insert function
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_index()
	{
		// Check id is null
		if ( ! \Input::post('id'))
		{
			return $this->response(array(
				'status'  => 'NG',
				'message' => 'Add measuring value failed!'
			), 403);
		}


	}
}