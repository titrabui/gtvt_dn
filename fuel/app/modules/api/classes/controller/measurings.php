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

		if (\Input::method() == 'POST')
		{
			$val = \Model_Milestone::validate('register');

			if ($val->run())
			{
				if ( ! $pagetitle = $this->get_page_title(\Input::post('url')))
				{
					\Session::set_flash('error','このURLが存在しない');
				}
				else
				{
					$milestone = \Model_Milestone::forge(array(
						'published'   => \Input::post('published'),
						'title'	      => \Input::post('title'),
						'description' => \Input::post('description'),
						'url'         => \Input::post('url'),
						'pagetitle'   => strpos($pagetitle, '\'') ? str_replace('\'', '', $pagetitle) : $pagetitle, // remove character ";" in pagetitle
					));

					\Session::set('milestone', $milestone);
					\Response::redirect('manager/milestones/confirm');
				}
			}
			else
			{
				\Session::set_flash('error', $val->error());
			}
		}
	}
}