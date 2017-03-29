<div class="row">
	<div class="col-lg-12 col-md-6 box-layout">
		<!-- small box -->
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-map-marker"></i></span>
				THÔNG TIN ĐIỂM ĐO
			</div>
			<div class="box-body">
				<div class="text-right">
					<a class="btn btn-md btn-primary" href="<?php echo Uri::create('moderator/projects'); ?>">
						<i class="fa fa-backward"></i>
						<span>QUAY LẠI</span>
					</a>
				</div>
				<hr>
				<div class="table-responsive">
					<?php $pagina_counter = Pagination::instance('measuring_points_pagination'); ?>
					<?php $no_counter = (($pagina_counter->current_page - 1) * $pagina_counter->per_page) + 1; ?>
					<table class="table table-hover">
						<thead>
							<tr class="tbl-header">
								<th class="text-center">STT</th>
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
									<td class="text-center"><?php echo $no_counter++; ?></td>
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
										<a class="btn btn-sm btn-primary" href="<?php echo Uri::create("moderator/measuring_values/view/".$onecase['id']); ?>">
											<i class="fa fa-exchange"></i>
											<span>Xem</span>
										</a>	
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
