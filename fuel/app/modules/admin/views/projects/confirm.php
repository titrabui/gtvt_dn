<?php
	$name = '';
	$location = '';
	$investor = '';
	$note = '';
	if (Session::get('project'))
	{
		$project = Session::get('project');
		$name = $project->name;
		$location = $project->location;
		$investor = $project->investor;
		$note = $project->note;

		if (isset($project->id))
		{
			$action = "admin/projects/confirm/".$project->id;
		}
		else
		{
			$action = "admin/projects/confirm";
		}
	}
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-md-offset-2 box-layout">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-hdd-o"></i></span>
				XÁC NHẬN DỰ ÁN
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
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Tên dự án</label></div>
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
						<div class="col-md-2 col-md-offset-1"><label class="control-common-label">Chủ đầu tư</label></div>
						<div class="col-md-8">
							<input type="text" class="form-control" id="investor" name="investor" value="<?php echo Input::post('investor', $investor); ?>" readonly>
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
							<button class="btn btn-md btn-primary" onclick="backToRegiserAndEditForm()">
								<span><i class="fa fa-backward"></i></span>
								Quay lại
							</button>
							<button class="btn btn-md btn-primary" onclick="projectConfirmSubmit()">
								<span><i class="fa fa-pencil"></i></span>
								Lưu
							</button>
						</div>
					</div>
				<?php echo Form::close(); ?>
			</div>
		</div>
	</div>
</div>
<?php echo Asset::js('app/project.js'); ?>