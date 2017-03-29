<?php

	class Constants
	{
		public static $site_title = '';

		public static $page_title = array(
			'normal' => '',
			'login' => 'Đăng nhập',
			'mainmenu' => '',
			'photoedit' => '',
			'photolist' => '',
			'photomap' => '',
			'changemail' => '',
			'changepass' => '',
		);

		public static $error_message = array(
			'login_error'             => 'Đăng nhập thất bại',
			'already_logged_in'       => 'Tài khoản đã đăng nhập rồi',
			'expired_csrf_token'      => 'There is no valid session.',
			'bad_old_password'        => 'Mật khẩu cũ không đúng',
			'not_change_mail'         => 'Địa chỉ email không thể thay đổi',
			'not_change_user_profile' => 'Thông tin người dùng không thể thêm hoặc thay đổi',
			'not_change_user_id_pass' => 'Mật khẩu không thể thêm hoặc thay đổi',
			'already_exist_user'      => 'Tài khoản người dùng đã được đăng ký rồi',
			'bad_route'               => 'Đường dẫn không hợp lệ',
			'not_exist_date'          => ':label Ngày không hợp lệ',
		);

		public static $user_group = array(
			'Administrators' => '100',
			'Moderators' => '50',
			'Users' => '1',
		);
	}

