<?php
namespace Api;

class Controller_Measuring_Points extends Controller_Base {

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
			if ( ! $id = \Input::post('project_id'))
			{
				$measuring_points = \Model_Measuring_Point::query()->get();
			}
			else
			{
				if ( ! $project = \Model_Project::find($id))
					return $this->error_response('Project #'.$id.' is not exist');

				$measuring_points = \Model_Measuring_Point::query()
					->where('project_id', $id)
					->get();
			}
			
			return $this->success_response($measuring_points);
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
			if ( ! $project_id = \Input::post('project_id'))
				return $this->error_response('project_id param is required');

			if ( ! $project = \Model_Project::find($project_id))
				return $this->error_response('Project #'.$project_id.' is not exist');

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
					'is_request'   => 0,
					'note'         => \Input::post('note'),
				));

				// save project
				if ( ! ($measuring_point and $measuring_point->save()))
					return $this->error_response('Could not registered measuring point');

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
			if (is_null($id))
				return $this->error_response('Request format is not valid');

			if ( ! $measuring_point = \Model_Measuring_Point::find($id))
				return $this->error_response('Measuring point #'.$id.' is not exist');

			if ( ! $project_id = \Input::post('project_id'))
				return $this->error_response('project_id param is required');

			if ( ! $project = \Model_Project::find($project_id))
				return $this->error_response('Project #'.$project_id.' is not exist');

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
			
				// save project
				if ( ! ($measuring_point and $measuring_point->save()))
					return $this->error_response('Could not edited measuring point');

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
			if (is_null($id))
				return $this->error_response('Request format is not valid');

			if ( ! $measuring_point = \Model_Measuring_Point::find($id))
				return $this->error_response('Measuring point #'.$id.' is not exist');

			if ( ! $measuring_point->delete())
				return $this->error_response('Could not deleted measuring point');

			return $this->success_response();
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}
}
