<?php
	$name = '';
	$location = '';
	$investor = '';
	$note = '';
	if (isset($project))
	{
		$id = $project->id;
		$name = $project->name;
		$location = $project->location;
		$investor = $project->investor;
		$note = $project->note;
	}
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-md-offset-2 box-layout">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-tasks"></i></span>
				CẬP NHẬT DỰ ÁN
			</div>
			<div class="box-body">
				<?php
				if (Session::get_flash('error')) {
					$error = Session::get_flash('error'); ?>
					<div class="row">
						<div class="col-md-8 col-md-offset-3">
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Có lỗi xảy ra.</strong><?php foreach ($error as $one) echo '<br>'.$one; ?>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php echo Form::open(array(
					'name'   => 'editform',
					'method' => 'post',
					'action' => 'admin/projects/edit/'.$id,
					'class'  => 'form-horizontal'
				)); ?>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tên dự án</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="name" name="name" value="<?php echo Input::post('name', $name); ?>" placeholder="Tên dự án">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Địa điểm</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="location" name="location" value="<?php echo Input::post('location', $location); ?>" placeholder="Địa điểm">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Chủ đầu tư</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="investor" name="investor" value="<?php echo Input::post('investor', $investor); ?>" placeholder="Chủ đầu tư">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Ghi chú</label></div>
						<div class="col-md-8">
							<textarea class="form-control" rows="3" name="note" placeholder="Ghi chú ..."><?php echo Input::post('note', $note); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/projects'); ?>">
								<span><i class="fa fa-backward"></i></span>
								Quay lại
							</a>
							<button type="submit" class="btn btn-md btn-primary">
								<span><i class="fa fa-pencil"></i></span>
								Xác nhận
							</button>
						</div>
					</div>
				<?php echo Form::close(); ?>
			</div>
		</div>
	</div>
</div>
