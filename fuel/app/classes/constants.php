<?php

	class Constants
	{
		public static $site_title = '静岡市パノラマ写真システム';

		public static $page_title = array(
			'normal' => 'サービスメニュー',
			'login' => 'ログイン',
			'mainmenu' => 'メインメニュー',
			'photoedit' => '写真編集',
			'photolist' => '登録一覧リスト',
			'photomap' => '登録地図',
			'changemail' => 'メールアドレス変更',
			'changepass' => 'パスワード変更',
		);

		public static $error_message = array(
			'login_error' => 'Đăng nhập thất bại',
			'already_logged_in' => 'Tài khoản đã đăng nhập rồi',
			'expired_csrf_token' => 'There is no valid session.',
			'bad_old_password' => 'Mật khẩu cũ không đúng',
			'not_change_mail' => 'Địa chỉ email không thể thay đổi',
			'not_change_user_profile' => 'ユーザー情報の追加・変更はできませんでした。',
			'not_change_user_id_pass' => 'パスワード・ログインIDの追加・変更はできませんでした。',
			'already_exist_user' => '入力したログインIDはすでに登録済みです。',
			'bad_route' => '不正なルートから遷移しています。',
			'not_exist_date' => ':label は 日付として正しくありません。',
			'not_change_photo_data' => '情報の追加・変更はできませんでした。',
		);

		public static $user_group = array(
			'Administrators' => '100',
			'Moderators' => '50',
			'Users' => '1',
		);

		public static $pagenate_config = array(
			'name' => 'bootstrap',
			'per_page' => '200',
			'num_link' => '5',
			'uri_segment' => 'page',
			'show_first' => true,
			'show_last' => true,
		);

		public static $range = 12;

		public static $search_meter = array(
			6 => 128,
			7 => 64,
			8 => 32,
			9 => 16,
			10 => 8,
			11 => 4,
			12 => 2,
			13 => 1,
			14 => 0.5,
			15 => 0.05,
			16 => 0.03,
			18 => 0.01,
			17 => 0.001,
		);


		public static $flag = array(
				'on' => '1',
				'off' => '0',
		);

		public static $publish_status = array(
				'1' => '公開',
				'0' => '非公開',
		);

		public static $commit_status = array(
				'-1' => '確定/未確定両方',
				'1' => '確定',
				'0' => '未確定',
		);

		public static $sendmail_status = array(
				'1' => '送信済み',
				'0' => '未送信',
		);
	}

