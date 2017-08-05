<?php
namespace Api;

class Controller_Measuring_Values extends Controller_Base {

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
			if ( ! $id = \Input::post('measuring_point_id'))
			{
				$measured_values = \Model_Measuring_Value::query()->get();
			}
			else
			{
				if ( ! $measuring_points = \Model_Measuring_Point::find($id))
					return $this->error_response('Measuring point #'.$id.' is not exist');

				if ( ! \Input::post('start_time') &&  ! \Input::post('end_time'))
				{
					$measured_values = \Model_Measuring_Value::query()
						->where('measuring_point_id', $id)
						->get();

					return $this->success_response($measured_values);
				}

				if (($start_time = \Input::post('start_time')) && ($end_time = \Input::post('end_time')))
				{
					if ($start_time > $end_time) return $this->error_response('start_time is not greater end_time');

					$measured_values = \Model_Measuring_Value::query()
						->where('measuring_point_id', $id)
						->and_where_open()
							->where('measuring_time', '>=', strtotime($start_time))
						->and_where_close()
						->and_where_open()
							->where('measuring_time', '<=', strtotime($end_time))
						->and_where_close()
						->order_by('measuring_time', 'desc')
						->from_cache(false)
						->get();
				}
				else
				{
					return $this->error_response('Request format is not valid');
				}
			}
			
			return $this->success_response($measured_values);
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}

	/**
	 * The add post
	 *
	 * @description  This function doesb't need to check token because it use for sending
	 * 					value from embedded system
	 * @access  public
	 * @return  Http code
	 */
	public function post_add()
	{
		try
		{
			if ( ! \Input::post('measuring_point_id'))
				return $this->error_response('Add measuring value failed');

			$measuring_point_val = \Model_Measuring_Point::validate('Measuring_Point_REST_API');
			$measuring_value_val = \Model_Measuring_Value::validate('measuring_value');

			if ($measuring_value_val->run() && $measuring_point_val->run())
			{
				$measuring_point_id = \Input::post('measuring_point_id');

				if ( ! $measuring_point = \Model_Measuring_Point::find($measuring_point_id))
					return $this->error_response('Measuring point #'.$measuring_point_id.' is not exist');

				// Set measuring points
				$measuring_point->id = $measuring_point_id;
				$measuring_point->account = \Input::post('account');
				$measuring_point->battery = \Input::post('battery');

				// Calculate surveying total time
				$last_measuring = \Model_Measuring_Value::find('last', array(
					'where' => array('measuring_point_id' => $measuring_point_id),
					'order_by' => array('measuring_time' => 'asc')
				));

				$total_time_surveying = 1;

				if (isset($last_measuring['id']))
				{
					$post_day = new \DateTime(\Input::post('date'));
					$last_day = new \DateTime(\Date::forge($last_measuring['measuring_time'])->format("%Y-%m-%d"));
					$interval = $post_day->diff($last_day);

					$total_time_surveying  = $interval->days + $last_measuring['total_time_surveying'];
				}

				// Set measuring values
				$measuring_value = \Model_Measuring_Value::forge(array(
					'measuring_point_id'   => $measuring_point_id,
					'total_time_surveying' => $total_time_surveying,
					'weather'              => $this->get_accu_weather(),
					'value1'               => \Input::post('value1'),
					'value2'               => \Input::post('value2'),
					'value3'               => \Input::post('value3'),
					'measuring_time'       => strtotime(\Input::post('date').'T'.\Input::post('time'))
				));

				if ($measuring_value and $measuring_value->save() and $measuring_point->save())
				{
					return $this->success_response('Add measuring value success');
				}
				else
				{
					return $this->error_response('Add measuring value failed');
				}
			}
			else
			{
				return $this->error_response(array($measuring_point_val->error(),$measuring_value_val->error()));
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

			if ( ! $measuring_value = \Model_Measuring_Value::find($id))
				return $this->error_response('Measuring value #'.$id.' is not exist');

			if ( ! $measuring_value->delete())
				return $this->error_response('Could not deleted measuring value');

			return $this->success_response();
		}
		catch (\Exception $e)
		{
			return $this->error_response($e->getMessage());
		}
	}
}
