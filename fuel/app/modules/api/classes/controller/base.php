<?php
namespace Api;

require_once (APPPATH.'vendor'.DS.'jwt'.DS.'JWT.php');
use \Firebase\JWT\JWT;

class Controller_Base extends \Controller_Rest
{
	// default format
	protected $format = 'json';
	protected $key = 'Aid48aksjf3i5qkskdf';
	protected $algorithm = array('HS256');

	public function before()
	{
		parent::before();
	}

	/**
	 * The checking authorization token function
	 *
	 * @access  protected
	 * @return  success: true | fail: false
	 */
	protected function check_authorization_token()
	{
		if ( ! $token = $this->get_bearer_token()) return null;
		try
		{
			JWT::$leeway = 60; // $leeway in seconds
			$jwt_decode = JWT::decode($token, $this->key, $this->algorithm);
			$jwt_data = $jwt_decode->data;
		}
		catch (\Exception $e)
		{
			return null;
		}
		catch (SignatureInvalidException $s)
		{
			return null;
		}
		catch (BeforeValidException $b)
		{
			return null;
		}
		catch (ExpiredException $exp)
		{
			return null;
		}

		if (!isset($jwt_data->username) or !isset($jwt_data->password)) return null;

		if ($user = \Auth::validate_user($jwt_data->username, $jwt_data->password))
		{
			return $user;
		}
		else
		{
			return null;
		}
	}

	/**
	 * The error response function
	 *
	 * @access  protected
	 * @return  Http code
	 */
	protected function error_response($response_data = [])
	{
		return $this->response(array(
			'status' => 'Error',
			'error' => $response_data
		), 401);
	}

	/**
	 * The success response function
	 *
	 * @access  protected
	 * @return  Http code
	 */
	protected function success_response($response_data = [])
	{
		return $this->response(array(
			'status' => 'Success',
			'data'  => $response_data
		), 200);
	}

	/**
	 * The bearer token getting function
	 *
	 * @access  protected
	 * @return  Token | null
	 */
	private function get_bearer_token()
	{
		$header =  apache_request_headers();
		if (!isset($header['Authorization'])) return null;

		if (preg_match('/Bearer\s(\S+)/', $header['Authorization'], $matches))
		{
			return $matches[1];
		}
	}

	/**
	 * The AccuWeather get function.
	 *
	 * @access  protected
	 * @return  string
	 */
	protected function get_accu_weather()
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

		if ($err) return 'Get weather failed,24';

		$json = substr($response, 1, -1);
		$result = json_decode($json, true);
		return $result['WeatherText'].','.$result['WeatherIcon'];
	}
}
