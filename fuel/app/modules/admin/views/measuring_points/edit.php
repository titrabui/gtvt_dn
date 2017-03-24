<?php
	$name = '';
	$location = '';
	$x_coordinate = '';
	$y_coordinate = '';
	$road_height = '';
	$note = '';

	if (isset($measuring_point))
	{
		$id = $measuring_point->id;
		$name = $measuring_point->name;
		$location = $measuring_point->location;
		$x_coordinate = $measuring_point->x_coordinate;
		$y_coordinate = $measuring_point->y_coordinate;
		$road_height = $measuring_point->road_height;
		$note = $measuring_point->note;
	}
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-md-offset-2 box-layout">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-tasks"></i></span>
				CẬP NHẬT ĐIỂM ĐO
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
					'action' => 'admin/measuring_points/edit/'.$id.'?project_id='.$project_id,
					'class'  => 'form-horizontal'
				)); ?>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tên điểm đo</label></div>
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
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tọa độ X</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="x_coordinate" name="x_coordinate" value="<?php echo Input::post('x_coordinate', $x_coordinate); ?>" placeholder="Tọa độ X">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tọa độ Y</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="y_coordinate" name="y_coordinate" value="<?php echo Input::post('y_coordinate', $y_coordinate); ?>" placeholder="Tọa độ Y">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Độ cao đường</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="road_height" name="road_height" value="<?php echo Input::post('road_height', $road_height); ?>" placeholder="Độ cao đường">
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
							<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/measuring_points/view/'.$project_id); ?>">
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
