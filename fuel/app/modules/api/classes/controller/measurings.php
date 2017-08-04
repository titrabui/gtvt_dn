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

				// Calculate surveying total time
				$last_measuring = \Model_Measuring_Value::find('last',array(
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
					'weather'              => $this->get_accuWeather(),
					'value1'               => \Input::post('value1'),
					'value2'               => \Input::post('value2'),
					'value3'               => \Input::post('value3'),
					'measuring_time'       => strtotime(\Input::post('date').'T'.\Input::post('time'))
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

	/**
	 * The AccuWeather get function.
	 *
	 * @access  private
	 * @return  string
	 */
	private function get_accuWeather()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL            => "http://apidev.accuweather.com/currentconditions/v1/352954.json?language=en&apikey=hoArfRosT1215",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "GET",
			CURLOPT_HTTPHEADER     => array(
				"cache-control: no-cache",
				"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
				"postman-token: 44db737a-edfa-373e-17ac-2dbe035685f1"
			),
			)
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) return '';

		$json = substr($response, 1, -1);
		$result = json_decode($json, true);
		return $result['WeatherText'].','.$result['WeatherIcon'];
	}
}