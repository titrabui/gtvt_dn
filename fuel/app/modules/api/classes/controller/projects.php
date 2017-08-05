<?php
namespace Api;

class Controller_Projects extends Controller_Base {

	public function before()
	{
		parent::before();
	}

	/**
	 * The index post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_index()
	{
		if ( ! $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');

		try
		{
			$projects = \Model_Project::query()->get();
			return $this->success_response($projects);
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}

	/**
	 * The register post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_register()
	{
		if ( ! $user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');
		if ($user['group'] != \Constants::$user_group['Administrators'])
			return $this->error_response('Access denied for user');

		try
		{
			$val = \Model_Project::validate('register');

			if ($val->run())
			{
				$project = \Model_Project::forge(array(
					'name'     => \Input::post('name'),
					'location' => \Input::post('location'),
					'investor' => \Input::post('investor'),
					'note'     => \Input::post('note')
				));

				// save project
				if ( ! ($project and $project->save())) return $this->error_response('Could not registered project');
				return $this->success_response();
			}
			else
			{
				$this->error_response($val->error());
			}
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}

	/**
	 * The edit post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_edit($id = null)
	{
		if ( ! $user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');
		if ($user['group'] != \Constants::$user_group['Administrators'])
			return $this->error_response('Access denied for user');

		try
		{
			if (is_null($id)) return $this->error_response('Request format is not valid');

			if ( ! $project = \Model_Project::find($id))
			{
				return $this->error_response('Project #'.$id.' is not exist');
			}

			$val = \Model_Project::validate('edit');

			if ($val->run())
			{
				$project->id       = $id;
				$project->name     = \Input::post('name');
				$project->location = \Input::post('location');
				$project->investor = \Input::post('investor');
				$project->note     = \Input::post('note');
			
				// save project
				if ( ! ($project and $project->save())) return $this->error_response('Could not edited project');
				return $this->success_response();
			}
			else
			{
				$this->error_response($val->error());
			}
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}

	/**
	 * The delete post.
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_delete($id = null)
	{
		if ( ! $user = $this->check_authorization_token())
			return $this->error_response('The access token could not be decrypted');
		if ($user['group'] != \Constants::$user_group['Administrators'])
			return $this->error_response('Access denied for user');

		try
		{
			if (is_null($id)) return $this->error_response('Request format is not valid');

			if ( ! $project = \Model_Project::find($id))
			{
				return $this->error_response('Project #'.$id.' is not exist');
			}

			if ( ! $project->delete()) return $this->error_response('Could not deleted project');
			return $this->success_response();
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}
}
