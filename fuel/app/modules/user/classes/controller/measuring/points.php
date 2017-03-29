<?php

namespace User;

class Controller_Measuring_Points extends Controller_Base {

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
	public function action_view($id = null)
	{
		try
		{
			is_null($id) and \Response::redirect('user/projects');

			if ( ! $project = \Model_Project::find($id))
			{
				\Session::set_flash('error', array('message' => 'Không tồn tại dự án #'.$id));
				\Response::redirect('user/error');
			}

			// pagination config
			$config = array(
				'name'           => 'bootstrap3',
				'pagination_url' => \Uri::create('user/measuring_points/view/'.$id),
				'total_items'    => \Model_Measuring_Point::query()->count(),
				'num_link'       => '5',
				'per_page'       => '20',
				'uri_segment'    => 'page',
			);

			$pagination = \Pagination::forge('measuring_points_pagination', $config);

			$data['measuring_points'] = \Model_Measuring_Point::query()
				->where('project_id', $id)
				->rows_offset($pagination->offset)
				->rows_limit($pagination->per_page)
				->get();

			$data['project_id'] = $id;
			$data['pagination'] = $pagination;

			$this->template->content = \View::forge('measuring_points/view', $data);
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
		\Session::get('measuring_point') and \Session::delete('measuring_point');

		// redirect to error page
		\Session::set_flash('error', $message);
		\Response::redirect('user/error');
	}
}

/* End of file measuring_point.php */