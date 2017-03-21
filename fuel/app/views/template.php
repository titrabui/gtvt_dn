<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hệ thống quản lý nhiệt độ bê tông nhựa | Quản lý</title>
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
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		 folder instead of downloading all of them to reduce the load. -->
	<?php echo Asset::css('dist/skins/_all-skins.min.css'); ?>
	<!-- iCheck -->
	<?php echo Asset::css('plugins/iCheck/flat/blue.css'); ?>
	<!-- Date Picker -->
	<?php echo Asset::css('plugins/datepicker/datepicker3.css'); ?>
	<!-- Daterange picker -->
	<?php echo Asset::css('plugins/daterangepicker/daterangepicker.css'); ?>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<header class="main-header">
		<!-- Logo -->
		<a href="<?php echo Uri::create('/') ?>" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b>A</b>LT</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>Admin</b>LTE</span>
		</a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			</a>

			<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs">
							<i class="fa fa-user"></i>
							<?php echo \View::$global_data['current_user']['username'];?>
						</span>
					</a>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="<?php echo Uri::create('logout') ?>">
						<span>
							<i class="fa fa-sign-out"></i>
							Đăng xuất
						</span>
					</a>
				</li>
			</ul>
			</div>
		</nav>
	</header>
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MENU CHÍNH</li>
				<li class="active treeview">
					<a href="<?php echo Uri::create('/') ?>">
						<i class="fa fa-dashboard"></i> <span>Dự án</span>
					</a>
				</li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content">
			<?php echo $content; ?>	
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Version</b> 2.3.8
	</div>
	<strong>Copyright &copy; 2017 <a href="http://ktlv.com">KTLV</a>.</strong> All rights
	reserved.
	</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	
</script>
<!-- jQuery 2.2.3 -->
<?php echo Asset::js('plugins/jQuery/jquery-2.2.3.min.js'); ?>
<!-- Bootstrap 3.3.6 -->
<?php echo Asset::js('bootstrap/js/bootstrap.min.js'); ?>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<?php echo Asset::js('plugins/daterangepicker/daterangepicker.js'); ?>
<!-- datepicker -->
<?php echo Asset::js('plugins/datepicker/bootstrap-datepicker.js'); ?>
<!-- FastClick -->
<?php echo Asset::js('plugins/fastclick/fastclick.js'); ?>
<!-- AdminLTE App -->
<?php echo Asset::js('dist/js/app.min.js'); ?>
</body>
</html>
