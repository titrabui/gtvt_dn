<?php

abstract class Controller_Hybrid extends \Fuel\Core\Controller_Hybrid
{
	public $modules;
	public $controller;
	public $action;
	public $fields = array ();

	public function before() {
		// setup the template if this isn't a RESTful call
		if (!$this->is_restful()) {
			if (!empty($this->template) and is_string($this->template)) {
				// Load the template
				$this->template = \View_Smarty::forge($this->template . '.tpl');
			}
		}
		$this->set_init();
		return parent::before();
	}

	/**
	 * 初期値を設定
	 */
	public function set_init() {
		$this->modules = Request::main()->module;
		$controller = strtolower(str_replace("Controller_", "", Request::main()->controller));
		$controller = str_replace($this->modules . "\\", "", $controller);
		$controller = str_replace("_", "/", $controller);
		$this->controller = $controller;
		$this->action = Request::main()->action;
		if (!empty($this->template) and !is_string($this->template)) {
			$this->template->modeuls = Request::main()->module;
			$this->template->controller = $controller;
			$this->template->action = Request::main()->action;
		}
	}

	/**
	 * フラッシュセッションにPOSTで渡されたデータをマージする
	 * 主に入力項目がある画面での初期化に使用
	 * 各自のコントローラーでfieldsに項目を設定する必要あり
	 */
	public function set_field_init() {
		foreach ($this->fields as $id => $field) {
			$type = (isset($field['type'])) ? $field['type'] : '';
			$default = (isset($field['default'])) ? $field['default'] : '';
			if ($id == 'mail') {
				$test = "";
			}
			$input = \Input::param($id);

			// Inputデータが入っていた場合
			if ($input !== null) {
				if(is_array($input) && implode("",$input) == ""){
					$aa = "";
				} else {
					\Session::set_flash($id, $input);
					continue;
				}
			}
			// セッションデータが入っていた場合
			$sess_val = \Session::get_flash($id);
			if ($sess_val) {
				\Session::set_flash($id, $sess_val);
				continue;
			}
			// どこにも引っかからない場合は初期値を設定
			\Session::set_flash($id, $default);
		}
	}

	/**
	 * POSTされた各データをフラッシュセッションに保存
	 * 各自のコントローラーでfieldsに項目を設定する必要あり
	 */
	public function set_post_session() {
		foreach ($this->fields as $id => $field) {
			$value = \Input::post($id);
			if (empty($value)) {
				$value = (isset($field['default'])) ? $field['default'] : '';
			}
			\Session::set_flash($id, $value);
		}

	}

	/**
	 * router
	 *
	 * this router will call action methods for normal requests,
	 * and REST methods for RESTful calls
	 *
	 * @param  string
	 * @param  array
	 */
	public function router($resource, $arguments) {
		// if this is an ajax call
		if (array_key_exists(\Input::extension(), $this->_supported_formats)) {
			\Config::load('rest', true);

			// If no (or an invalid) format is given, auto detect the format
			if (is_null($this->format) or !array_key_exists($this->format, $this->_supported_formats)) {
				// auto-detect the format
				$this->format = array_key_exists(\Input::extension(), $this->_supported_formats) ? \Input::extension() : $this->_detect_format();
			}

			// Get the configured auth method if none is defined
			$this->auth === null and $this->auth = \Config::get('rest.auth');

			//Check method is authorized if required, and if we're authorized
			if ($this->auth == 'basic') {
				$valid_login = $this->_prepare_basic_auth();
			} elseif ($this->auth == 'digest') {
				$valid_login = $this->_prepare_digest_auth();
			} elseif (method_exists($this, $this->auth)) {
				if (($valid_login = $this->{$this->auth}()) instanceOf \Response) {
					return $valid_login;
				}
			} else {
				$valid_login = false;
			}

			//If the request passes auth then execute as normal
			if (empty($this->auth) or $valid_login) {
				// If they call user, go to $this->post_user();
				$controller_method = strtolower(\Input::method()) . '_' . $resource;

				// Fall back to action_ if no rest method is provided
				if (!method_exists($this, $controller_method)) {
					$controller_method = 'action_' . $resource;
				}

				// If method is not available, set status code to 404
				if (method_exists($this, $controller_method)) {
					return call_fuel_func_array(array ($this, $controller_method), $arguments);
				} else {
					$this->response->status = $this->no_method_status;
					return;
				}
			} else {
				$this->response(array ('status' => 0, 'error' => 'Not Authorized'), 401);
			}
			return;
		}

		// check if a input specific method exists
		$controller_method = strtolower(\Input::method()) . '_' . $resource;

		// fall back to action_ if no rest method is provided
		if (!method_exists($this, $controller_method)) {
			$controller_method = 'action_' . $resource;
		}

		// check if the action method exists
		if (method_exists($this, $controller_method)) {
			return call_fuel_func_array(array ($this, $controller_method), $arguments);
		}

		// if not, we got ourselfs a genuine 404!
		throw new \HttpNotFoundException();
	}

}
