<?php

namespace Moderator;

class Controller_Projects extends Controller_Base {

	public function before()
	{
		parent::before();

	}

	/**
	 * The index action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_index()
	{
		try
		{
			// pagination config
			$config = array(
				'name'           => 'bootstrap3',
				'pagination_url' => \Uri::create('moderator/projects'),
				'total_items'    => \Model_Project::query()->count(),
				'num_link'       => '5',
				'per_page'       => '20',
				'uri_segment'    => 'page',
			);

			$pagination = \Pagination::forge('projects_pagination', $config);

			$data['projects'] = \Model_Project::query()
				->rows_offset($pagination->offset)
				->rows_limit($pagination->per_page)
				->get();

			$data['pagination'] = $pagination;

			$this->template->content = \View::forge('projects/index', $data);
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The function for redirecting to error page
	 *
	 * @access  private
	 * @return  none
	 */
	private function redirect_to_error_page($message = array())
	{
		// remove project session
		\Session::get('project') and \Session::delete('project');

		// redirect to error page
		\Session::set_flash('error', $message);
		\Response::redirect('moderator/error');
	}
}

/* End of file projects.php */