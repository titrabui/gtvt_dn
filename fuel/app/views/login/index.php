<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>HỆ THỐNG QUẢN LÝ DỮ LIỆU NHIỆT ĐỘ BÊ TÔNG NHỰA | Đăng nhập</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<?php echo Asset::css('bootstrap/bootstrap.min.css'); ?>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<?php echo Asset::css('dist/AdminLTE.min.css'); ?>
	<!-- iCheck -->
	<?php echo Asset::css('plugins/iCheck/square/blue.css'); ?>

	<?php echo Asset::css('style.css'); ?>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition login-page" style="background: url('<?php echo Asset::get_file('login_bg.jpg', 'img');?>');">
<div class="row">
	<div class="login-logo" style="margin-top: 40px;">
		<div class="col-lg-4 col-md-6">
			<!-- So GTVT -->
			<?php echo Asset::img('logo-danang.png', array('class' => 'investor-logo')); ?>
			<!-- BkECC -->
			<?php echo Asset::img('Bk-ecc.jpg', array('class' => 'investor-logo')); ?>
			<!-- BKDN -->
			<?php echo Asset::img('logo-bkdn.jpg', array('class' => 'investor-logo')); ?>
		</div>
		<div class="col-lg-4 col-md-6">
			<a style="color: #d2d6de" href="<?php echo Uri::create('/') ?>"><b>HỆ THỐNG QUẢN LÝ<br>DỮ LIỆU NHIỆT ĐỘ BÊ TÔNG NHỰA</b></a>
		</div>
		<div class="col-lg-4 col-md-6">
			<!-- Khoa cau duong -->
			<?php echo Asset::img('logo-cauduongbkdn.JPEG', array('class' => 'investor-logo')); ?>
			<!-- BK-ITEC -->
			<?php echo Asset::img('BK-ITEC_Logo.png', array('class' => 'investor-logo')); ?>
			<!-- CEI -->
			<?php echo Asset::img('CEI_logo_1.png', array('class' => 'investor-logo')); ?>
		</div>
	</div>
</div>
<div class="login-box">
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">ĐĂNG NHẬP HỆ THỐNG</p>

		<form action="<?php echo \Uri::create('/login'); ?>" method="post">
			<div class="form-group has-feedback">
				<input type="text" name="username" class="form-control" placeholder="Tài khoản">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="password" class="form-control" placeholder="Mật khẩu">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox"> Remember Me
						</label>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
				</div>
				<!-- /.col -->
			</div>
		</form>
	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 2.2.3 -->
<?php echo Asset::js('plugins/jQuery/jquery-2.2.3.min.js'); ?>
<!-- Bootstrap 3.3.6 -->
<?php echo Asset::js('bootstrap/js/bootstrap.min.js'); ?>
<!-- iCheck -->
<?php echo Asset::js('plugins/iCheck/icheck.min.js'); ?>
<script>
	$(function () {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	});
</script>
</body>
</html>
