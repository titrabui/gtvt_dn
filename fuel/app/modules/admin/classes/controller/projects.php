<?php

namespace Admin;

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
				'pagination_url' => \Uri::create('admin/projects'),
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
			\Session::get('project') and \Session::delete('project');

			if (\Input::method() == 'POST' && ! \Input::post('back'))
			{
				$val = \Model_Project::validate('register');

				if ($val->run())
				{
					$project = \Model_Project::forge(array(
						'name'     => \Input::post('name'),
						'location' => \Input::post('location'),
						'investor' => \Input::post('investor'),
						'note'     => \Input::post('note'),
					));

					\Session::set('project', $project);
					\Response::redirect('admin/projects/confirm');
				}
				else
				{
					\Session::set_flash('error', $val->error());
				}
			}

			$this->template->content = \View::forge('projects/register.php');
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
			\Session::get('project') and \Session::delete('project');

			is_null($id) and \Response::redirect('admin/projects');

			if ( ! $project = \Model_Project::find($id))
			{
				$this->redirect_to_error_page(array('message' => 'Không tồn tại dự án #'.$id));
			}

			if ( ! \Input::post('back'))
			{
				$val = \Model_Project::validate('edit');

				if ($val->run())
				{
					$project->id       = $id;
					$project->name     = \Input::post('name');
					$project->location = \Input::post('location');
					$project->investor = \Input::post('investor');
					$project->note     = \Input::post('note');
				
					\Session::set('project', $project);
					\Response::redirect('admin/projects/confirm/'.$id);
				}
				else
				{
					if (\Input::method() == 'POST')
					{
						$project->name = $val->validated('name');
						$project->location = $val->validated('location');
						$project->investor = $val->validated('investor');
						$project->note = $val->validated('note');

						\Session::set_flash('error', $val->error());
					}
				}
			}

			$this->template->content = \View::forge('projects/edit.php', array('project' => $project));
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
				// prevent redirect without projects data from edit or register
				(\Input::referrer() == '') and $this->redirect_to_error_page(array('message' =>'Không được thực hiện hành động này vì lý do bảo mật'));
			}
			else
			{
				// remove project session
				\Session::delete('project');

				( ! is_null($id) && ! $project = \Model_Project::find($id)) and $this->redirect_to_error_page(array('message' => 'Không tồn tại dự án #'.$id));

				// check token from confirm form
				\Security::check_token() or $this->redirect_to_error_page(\Constants::$error_message['expired_csrf_token']);

				$val = \Model_Project::validate('confirm');

				if ($val->run())
				{
					if (isset($project))
					{
						// save data to edit
						$project->id       = $id;
						$project->name     = \Input::post('name');
						$project->location = \Input::post('location');
						$project->investor = \Input::post('investor');
						$project->note     = \Input::post('note');
					}
					else
					{
						// create new one and save data to register
						$project = \Model_Project::forge(array(
							'name'     => \Input::post('name'),
							'location' => \Input::post('location'),
							'investor' => \Input::post('investor'),
							'note'     => \Input::post('note'),
						));
					}

					// save project
					($project and $project->save()) or $this->redirect_to_error_page(array('message' => 'Không thể lưu dự án này'));
					\Session::set_flash('complete', 'complete');
					\Response::redirect('admin/projects/complete');	
				}
				else
				{
					$this->redirect_to_error_page($val->error());
				}
			}
		
			$this->template->content = \View::forge('projects/confirm.php');
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
		\Session::get_flash('complete') or \Response::redirect('admin/projects');
		$this->template->content = \View::forge('projects/complete.php');
	}

	/**
	 * The delete action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function action_delete($id = null)
	{
		is_null($id) and \Response::redirect('admin/projects');

		if ( ! $project = \Model_Project::find($id))
		{
			$this->redirect_to_error_page(array('message' => 'Không tồn tại dự án #'.$id));
		}

		$project->delete() or $this->redirect_to_error_page(array('message' => 'Không thể xóa dự án này'));
		\Response::redirect('admin/projects');
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
		\Response::redirect('admin/error');
	}
}

/* End of file projects.php */