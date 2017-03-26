<div class="row">
	<div class="col-lg-12 col-md-6 box-layout">
		<!-- small box -->
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-tasks"></i></span>
				THÔNG TIN ĐIỂM ĐO
			</div>
			<div class="box-body">
				<div class="text-right">
					<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/projects'); ?>">
						<i class="fa fa-arrow-left"></i>
						<span>QUAY LẠI</span>
					</a>
					<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/measuring_points/register?project='.$project_id); ?>">
						<i class="fa fa-plus"></i>
						<span>THÊM ĐIỂM ĐO</span>
					</a>
				</div>
				<hr>
				<div class="table-responsive">
					<?php $pagina_counter = Pagination::instance('measuring_points_pagination'); ?>
					<?php $no_counter = (($pagina_counter->current_page - 1) * $pagina_counter->per_page) + 1; ?>
					<table class="table table-hover">
						<thead>
							<tr class="tbl-header">
								<th class="no">NO</th>
								<th>Điểm đo</th>
								<th>Code</th>
								<th>Vị trí</th>
								<th>Tọa độ X</th>
								<th>Tọa độ Y</th>
								<th>Cao độ đường</th>
								<th>Tài khoản (VND)</th>
								<th>Pin (%)</th>
								<th>Ghi chú</th>
								<th class="edit-route"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($measuring_points as $onecase) { ?>
								<tr>
									<td class="no"><?php echo $no_counter++; ?></td>
									<td><?php echo Str::truncate($onecase['name'], 80); ?></td>
									<td><?php echo $onecase['id']; ?></td>
									<td><?php echo Str::truncate($onecase['location'], 80); ?></td>
									<td><?php echo $onecase['x_coordinate']; ?></td>
									<td><?php echo $onecase['y_coordinate']; ?></td>
									<td><?php echo $onecase['road_height']; ?></td>
									<td><?php echo Str::truncate($onecase['account'], 80); ?></td>
									<td><?php echo $onecase['battery']; ?></td>
									<td><?php echo Str::truncate($onecase['note'], 80); ?></td>
									<td class="edit-route pull-right">
										<a class="btn btn-sm btn-primary" href="<?php echo Uri::create("admin/measuring_values/view/".$onecase['id']); ?>">
											<i class="fa fa-exchange"></i>
											<span>Xem</span>
										</a>	
										<a class="btn btn-sm btn-warning" href="<?php echo Uri::create("admin/measuring_points/edit/".$onecase['id'].'?project='.$project_id); ?>">
											<i class="fa fa-edit"></i>
											<span>Sửa</span>
										</a>
										<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#measuringPointModal" data-whatever="<?php echo Uri::create("admin/measuring_points/delete/".$onecase['id'].'?project=').$project_id.','.$onecase['name']; ?>">
											<i class="fa fa-trash"></i>
											<span>Xóa</span>
										</button>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<?php if (count($measuring_points) == 0) { ?>
					<div class="row text-center">Không có dữ liệu</div>
				<?php } ?>
				<div class="row text-center"><?php echo html_entity_decode($pagination); ?></div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal modal-warning" id="measuringPointModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<p class="modal-message">Bạn có chắc chắn muốn xóa điểm đo này không?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-outline modal-submit">Xóa</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php echo Asset::js('app/measuring_point.js'); ?>
