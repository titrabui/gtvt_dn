<?php

namespace Admin;

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
			is_null($id) and \Response::redirect('admin/projects');

			if ( ! $project = \Model_Project::find($id))
			{
				\Session::set_flash('error', array('message' => 'Không tồn tại dự án #'.$id));
				\Response::redirect('admin/error');
			}

			// pagination config
			$config = array(
				'name'           => 'bootstrap3',
				'pagination_url' => \Uri::create('admin/measuring_points/view/'.$id),
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
	 * The register action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_register()
	{
		try
		{
			// remove project session
			\Session::get('measuring_point') and \Session::delete('measuring_point');

			(! \Input::get('project')) and \Response::redirect('admin/projects');

			$project_id = \Input::get('project');
			if ( ! $project = \Model_Project::find($project_id))
			{
				$this->redirect_to_error_page(array('message' => 'Không tồn tại dự án #'.$project_id));
			}

			if (\Input::method() == 'POST' &&  ! \Input::post('back'))
			{
				$val = \Model_Measuring_Point::validate('Measuring_Point_Page');

				if ($val->run())
				{
					$measuring_point = \Model_Measuring_Point::forge(array(
						'project_id'   => $project_id,
						'name'         => \Input::post('name'),
						'location'     => \Input::post('location'),
						'x_coordinate' => \Input::post('x_coordinate'),
						'y_coordinate' => \Input::post('y_coordinate'),
						'road_height'  => \Input::post('road_height'),
						'note'         => \Input::post('note'),
					));

					\Session::set('measuring_point', $measuring_point);
					\Response::redirect('admin/measuring_points/confirm?project='.$project_id);
				}
				else
				{
					\Session::set_flash('error', $val->error());
				}
			}

			$data['project_id'] = $project_id;
			$this->template->content = \View::forge('measuring_points/register.php', $data);
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The edit action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_edit($id = null)
	{
		try
		{
			// remove project session
			\Session::get('measuring_point') and \Session::delete('measuring_point');

			(is_null($id) || ! \Input::get('project')) and \Response::redirect('admin/projects');

			if ( ! $measuring_point = \Model_Measuring_Point::find($id))
			{
				$this->redirect_to_error_page(array('message' => 'Không tồn tại điểm đo #'.$id));
			}

			$project_id = \Input::get('project');
			if ( ! $project = \Model_Project::find($project_id))
			{
				$this->redirect_to_error_page(array('message' => 'Không tồn tại dự án #'.$project_id));
			}

			if ( ! \Input::post('back'))
			{
				$val = \Model_Measuring_Point::validate('Measuring_Point_Page');

				if ($val->run())
				{
					$measuring_point->id           = $id;
					$measuring_point->project_id   = $project_id;
					$measuring_point->name         = \Input::post('name');
					$measuring_point->location     = \Input::post('location');
					$measuring_point->x_coordinate = \Input::post('x_coordinate');
					$measuring_point->y_coordinate = \Input::post('y_coordinate');
					$measuring_point->road_height  = \Input::post('road_height');
					$measuring_point->note         = \Input::post('note');

					\Session::set('measuring_point', $measuring_point);
					\Response::redirect('admin/measuring_points/confirm/'.$id.'?project='.$project_id);
				}
				else
				{
					if (\Input::method() == 'POST')
					{
						$measuring_point->name         = $val->validated('name');
						$measuring_point->location     = $val->validated('location');
						$measuring_point->x_coordinate = $val->validated('x_coordinate');
						$measuring_point->y_coordinate = $val->validated('y_coordinate');
						$measuring_point->road_height  = $val->validated('road_height');
						$measuring_point->note         = $val->validated('note');

						\Session::set_flash('error', $val->error());
					}
				}
			}

			$this->template->content = \View::forge('measuring_points/edit.php', array('measuring_point' => $measuring_point, 'project_id' => $project_id));
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The confirm action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_confirm($id = null)
	{
		try
		{
			if (\Input::method() != 'POST')
			{
				// prevent redirect without measuring_point data from edit or register
				(\Input::referrer() == '') and $this->redirect_to_error_page(array('message' =>'Không được thực hiện hành động này vì lý do bảo mật'));
			}
			else
			{
				// remove measuring_point session
				\Session::delete('measuring_point');

				(! \Input::get('project')) and \Response::redirect('admin/projects');

				if ( ! is_null($id) && ! $measuring_point = \Model_Measuring_Point::find($id))
				{
					$this->redirect_to_error_page(array('message' => 'Không tồn tại điểm đo #'.$id));
				}

				$project_id = \Input::get('project');
				if ( ! $project = \Model_Project::find($project_id))
				{
					$this->redirect_to_error_page(array('message' => 'Không tồn tại dự án #'.$project_id));
				}

				// check token from confirm form
				\Security::check_token() or $this->redirect_to_error_page(array('message' => \Constants::$error_message['expired_csrf_token']));

				$val = \Model_Measuring_Point::validate('Measuring_Point_Page');

				if ($val->run())
				{
					if (isset($measuring_point))
					{
						// save data to edit
						$measuring_point->id           = $id;
						$measuring_point->project_id   = $project_id;
						$measuring_point->name         = \Input::post('name');
						$measuring_point->location     = \Input::post('location');
						$measuring_point->x_coordinate = \Input::post('x_coordinate');
						$measuring_point->y_coordinate = \Input::post('y_coordinate');
						$measuring_point->road_height  = \Input::post('road_height');
						$measuring_point->note         = \Input::post('note');
					}
					else
					{
						// create new one and save data to register
						$measuring_point = \Model_Measuring_Point::forge(array(
							'project_id'   => $project_id,
							'name'         => \Input::post('name'),
							'location'     => \Input::post('location'),
							'x_coordinate' => \Input::post('x_coordinate'),
							'y_coordinate' => \Input::post('y_coordinate'),
							'road_height'  => \Input::post('road_height'),
							'is_request'   => 0,
							'note'         => \Input::post('note'),
						));
					}

					// save measuring_point
					($measuring_point and $measuring_point->save()) or $this->redirect_to_error_page(array('message' => 'Không thể lưu điểm đo này'));
					\Session::set_flash('project_id', $project_id);
					\Response::redirect('admin/measuring_points/complete');	
				}
				else
				{
					$this->redirect_to_error_page($val->error());
				}
			}
		
			$this->template->content = \View::forge('measuring_points/confirm.php');
		}
		catch (\Exception $e)
		{
			$this->redirect_to_error_page($e->getMessage());
		}
	}

	/**
	 * The complete action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_complete()
	{
		$project_id = \Session::get_flash('project_id') or \Response::redirect('admin/projects');
		$this->template->content = \View::forge('measuring_points/complete.php', array('project_id' => $project_id));
	}

	/**
	 * The delete action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_delete($id = null)
	{
		( ! \Input::get('project')) and \Response::redirect('admin/projects');

		if ( ! is_null($id) && ! $measuring_point = \Model_Measuring_Point::find($id))
		{
			$this->redirect_to_error_page(array('message' => 'Không tồn tại điểm đo #'.$id));
		}

		$project_id = \Input::get('project');
		if ( ! $project = \Model_Project::find($project_id))
		{
			$this->redirect_to_error_page(array('message' => 'Không tồn tại dự án #'.$project_id));
		}

		$measuring_point->delete() or $this->redirect_to_error_page(array('message' => 'Không thể xóa điểm đo này'));
		\Response::redirect('admin/measuring_points/view/'.$project_id);
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
		\Response::redirect('admin/error');
	}
}

/* End of file measuring_point.php */