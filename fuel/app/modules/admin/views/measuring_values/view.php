<div class="row">
	<div class="col-lg-12 col-md-6 box-layout">
		<!-- small box -->
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-tasks"></i></span>
				ĐIỂM ĐO: <?php echo $measuring_points['name']; ?>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<?php if (count($measuring_values) > 0) { ?>
							<?php echo Form::open(array(
								'name'   => 'monthform',
								'method' => 'get',
								'action' => 'admin/measuring_values/view/'.$measuring_points['id'],
								'class'  => 'form-group month-form'
							)); ?>
							<div class="col-lg-3 col-md-3"><label class="control-common-label">Xem theo tháng</label></div>
							<div class="col-lg-4 col-md-4">
								<?php echo Form::select('month_selected', $month_selected, $measuring_months, array('class' => 'form-control month-select')); ?>
							</div>
							<?php echo Form::close(); ?>
						<?php } ?>
					</div> <!-- col-lg-6 col-md-6 /-->
					<div class="col-lg-6 col-md-6">
						<div class="text-right">
							<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/measuring_points/view/'.$measuring_points['project_id']); ?>">
								<i class="fa fa-backward"></i>
								<span>QUAY LẠI</span>
							</a>
							<?php if (count($measuring_values) > 0) { ?>
								<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/measuring_values/report/'.$measuring_points['id'].'?month_selected='.$month_selected); ?>">
									<i class="fa fa-download"></i>
									<span>XUẤT DỮ LIỆU</span>
								</a>
							<?php } ?>
						</div>
					</div> <!-- col-lg-6 col-md-6 /-->
				</div> <!-- row /-->
				<hr>
				<div class="table-responsive">
					<?php $pagina_counter = Pagination::instance('measuring_values_pagination'); ?>
					<?php $no_counter = (($pagina_counter->current_page - 1) * $pagina_counter->per_page) + 1; ?>
					<table class="table table-hover">
						<thead>
							<tr class="tbl-header">
								<th></th>
								<th class="text-center">STT</th>
								<th>Ngày</th>
								<th>Thời gian</th>
								<th class="text-center">Tổng thời gian<br>khảo sát (ngày)</th>
								<th class="text-center">Thời tiết</th>
								<th class="text-center">Nhiệt độ<br>bên ngoài (&#8451;)</th>
								<th class="text-center">Nhiệt độ<br>vị trí 1 dưới kết cấu (&#8451;)</th>
								<th class="text-center">Nhiệt độ<br>vị trí 2 dưới kết cấu (&#8451;)</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($measuring_values as $onecase) { 
								$weather = explode(',', $onecase['weather']);
								$weather_icon = '';
								$weather_current = '';
								if (isset($weather[1]))
								{
									$weather_icon = Asset::img('accuweather_icons/'.$weather[1].'.png');
									$weather_current = $weather[0];
								} ?>
								<tr>
									<td>
										<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#measuringValueModal" data-whatever="<?php echo Uri::create("admin/measuring_values/delete/".$onecase['id'].'?measuring_point='.$onecase['measuring_point_id']).','.str_replace(',', '', $measuring_points['name']).','.Date::forge($onecase['measuring_time'])->format("%d - %m - %Y").','.Date::forge($onecase['measuring_time'])->format("%H : %M : %S"); ?>">
											<i class="fa fa-trash"></i>
											<span>Xóa</span>
										</button>
									</td>
									<td class="text-center"><?php echo $no_counter++; ?></td>
									<td><?php echo Date::forge($onecase['measuring_time'])->format("%d - %m - %Y"); ?></td>
									<td><?php echo Date::forge($onecase['measuring_time'])->format("%H : %M : %S"); ?></td>
									<td class="text-center"><?php echo $onecase['total_time_surveying']; ?></td>
									<td class="text-center"><?php echo $weather_icon; echo $weather_current;?></td>
									<td class="text-center"><?php echo $onecase['value1']; ?></td>
									<td class="text-center"><?php echo $onecase['value2']; ?></td>
									<td class="text-center"><?php echo $onecase['value3']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div> <!-- table-responsive /-->
				<?php if (count($measuring_values) == 0) { ?>
					<div class="row text-center">Không có dữ liệu</div>
				<?php } ?>
				<div class="row text-center"><?php echo html_entity_decode($pagination); ?></div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal modal-warning" id="measuringValueModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<p class="modal-message">Bạn có chắc chắn muốn xóa giá trị đo này không?</p>
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
<?php echo Asset::js('app/measuring_value.js'); ?>