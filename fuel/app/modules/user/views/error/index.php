<div class="row">
	<div class="col-lg-6 col-md-6 col-md-offset-3 box-layout">
		<div class="box box-danger box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-bug"></i></span>
				ERROR
			</div>
			<div class="box-body text-center">
				<?php if (Session::get_flash('error')) {
					$error = Session::get_flash('error');?>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Có lỗi xảy ra.</strong><?php
									foreach ($error as $one) {
										echo '<br>'.$one;
									} 
								?>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="margin-top25">
					<a class="btn btn-md btn-primary" href="<?php echo Uri::create('user/projects'); ?>">
						<i class="fa fa-backward"></i>
						<span>Quay lại</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
