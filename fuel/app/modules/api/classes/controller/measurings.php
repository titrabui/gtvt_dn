<?php
namespace Api;

class Controller_Measurings extends \Controller_Rest
{
	// default format
    protected $format = 'json';

	/**
	 * The measuring insert function
	 *
	 * @access  public
	 * @return  Http code
	 */
	public function post_index()
	{
		// Check id is null
		if ( ! \Input::post('measuring_point_id'))
		{
			return $this->response(array(
				'status'  => 'NG',
				'message' => 'Add measuring value failed!'
			), 403);
		}

		if (\Input::method() == 'POST')
		{
			$measuring_point_val = \Model_Measuring_Point::validate('Measuring_Point_REST_API');
			$measuring_value_val = \Model_Measuring_Value::validate('measuring_value');

			if ($measuring_value_val->run() && $measuring_point_val->run())
			{
				$measuring_point_id = \Input::post('measuring_point_id');

				if ( ! $measuring_point = \Model_Measuring_Point::find($measuring_point_id))
				{
					return $this->response(array(
						'status'  => 'NG',
						'message' => 'Add measuring value failed!'
					), 403);
				}

				// Set measuring points
				$measuring_point->id = $measuring_point_id;
				$measuring_point->account = \Input::post('account');
				$measuring_point->battery = \Input::post('battery');

				// Set measuring values
				$measuring_value = \Model_Measuring_Value::forge(array(
					'measuring_point_id' => $measuring_point_id,
					'value1'             => \Input::post('value1'),
					'value2'             => \Input::post('value2'),
					'value3'             => \Input::post('value3'),
				));

				if ($measuring_value and $measuring_value->save() and $measuring_point->save())
				{
					return $this->response(array(
						'status'  => 'OK',
						'message' => 'Add measuring value success!'
					), 201);
				}
				else
				{
					return $this->response(array(
						'status'  => 'NG',
						'message' => 'Add measuring value failed!'
					), 403);
				}
			}
			else
			{
				return $this->response(array(
					'status'  => 'NG',
					'message' => array($measuring_point_val->error(),$measuring_value_val->error())
				), 403);
			}
		}
	}
}