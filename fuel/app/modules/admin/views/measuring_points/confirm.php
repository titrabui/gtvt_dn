<?php
	$name = '';
	$location = '';
	$x_coordinate = '';
	$y_coordinate = '';
	$road_height = '';
	$note = '';
	if (Session::get('measuring_point'))
	{
		$measuring_point = Session::get('measuring_point');
		$name = $measuring_point->name;
		$location = $measuring_point->location;
		$x_coordinate = $measuring_point->x_coordinate;
		$y_coordinate = $measuring_point->y_coordinate;
		$road_height = $measuring_point->road_height;
		$note = $measuring_point->note;

		if (isset($measuring_point->id))
		{
			$action = "admin/measuring_points/confirm/".$measuring_point->id.'?project='.$measuring_point->project_id;
		}
		else
		{
			$action = "admin/measuring_points/confirm?project=".$measuring_point->project_id;
		}
	}
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-md-offset-2 box-layout">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-hdd-o"></i></span>
				XÁC NHẬN ĐIỂM ĐO
			</div>
			<div class="box-body margin-left20">
				<?php echo Form::open(array(
					'name'   => 'confirmform',
					'method' => 'post',
					'action' => $action,
					'class'  => 'form-horizontal',
					'id'     => 'confirm-form'
				)); ?>
					<input type="hidden" name="<?php echo \Config::get('security.csrf_token_key'); ?>" value="<?php echo \Security::fetch_token(); ?>">
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tên điểm đo</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="name" name="name" value="<?php echo Input::post('name', $name); ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Địa điểm</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="location" name="location" value="<?php echo Input::post('location', $location); ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tọa độ X</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="x_coordinate" name="x_coordinate" value="<?php echo Input::post('x_coordinate', $x_coordinate); ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tọa độ Y</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="y_coordinate" name="y_coordinate" value="<?php echo Input::post('y_coordinate', $y_coordinate); ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Độ cao đường</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="road_height" name="road_height" value="<?php echo Input::post('road_height', $road_height); ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Ghi chú</label></div>
						<div class="col-md-8">
							<textarea class="form-control" rows="3" name="note" readonly><?php echo Input::post('note', $note); ?></textarea>
						</div>
					</div>					
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-md btn-primary" onclick="backToRegiserAndEditForm(<?php echo $measuring_point->project_id?>)">
								<span><i class="fa fa-backward"></i></span>
								Quay lại
							</button>
							<button class="btn btn-md btn-primary" onclick="measuringPointConfirmSubmit()">
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
<?php echo Asset::js('app/measuring_point.js'); ?>