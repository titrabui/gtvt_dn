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
					<div class="col-lg-2 col-md-6">
						<?php echo Form::open(array(
							'name'   => 'monthform',
							'method' => 'get',
							'action' => 'admin/measuring_values/view/'.$measuring_points['project_id'],
							'class'  => 'form-group month-form'
						)); ?>
						<?php echo Form::select('month_selected', $month_selected, $measuring_months, array('class' => 'form-control month-select')); ?>
						<?php echo Form::close(); ?>
					</div> <!-- col-lg-6 col-md-6 /-->
					<div class="col-lg-10 col-md-6">
						<div class="text-right">
							<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/measuring_points/view/'.$measuring_points['project_id']); ?>">
								<i class="fa fa-arrow-left"></i>
								<span>QUAY LẠI</span>
							</a>
							<?php if (count($measuring_values) > 0) { ?>
								<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/measuring_values/export'); ?>">
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
								<th class="text-center">NO</th>
								<th>Ngày</th>
								<th>Thời gian</th>
								<th class="text-center">Tổng thời gian<br>khảo sát (ngày)</th>
								<th class="text-center">Thời tiết</th>
								<th class="text-center">Nhiệt độ<br>bên ngoài (&#8451;)</th>
								<th class="text-center">Nhiệt độ<br>vị trí 1 dưới kết cấu (&#8451;)</th>
								<th class="text-center">Nhiệt độ<br>vị trí 2 dưới kết cấu (&#8451;)</th>
								<th class="edit-route"></th>
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
									<td class="text-center"><?php echo $no_counter++; ?></td>
									<td><?php echo Date::forge($onecase['created_at'])->format("%d - %m - %Y"); ?></td>
									<td><?php echo Date::forge($onecase['created_at'])->format("%H : %M : %S"); ?></td>
									<td class="text-center"><?php echo $onecase['total_time_surveying']; ?></td>
									<td class="text-center"><?php echo $weather_icon; echo $weather_current;?></td>
									<td class="text-center"><?php echo $onecase['value1']; ?></td>
									<td class="text-center"><?php echo $onecase['value2']; ?></td>
									<td class="text-center"><?php echo $onecase['value3']; ?></td>
									<td class="edit-route pull-right">
										<a class="btn btn-sm btn-danger" href="#">
											<i class="fa fa-trash"></i>
											<span>Xóa</span>
										</a>
									</td>
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
<div class="modal fade" id="milestone-modal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="background: #00a65a;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="text-align: center;">
				<a id="milestone-url" href="" target="_balnk">
					<img src="" id="milestone-thumbnail" class="img-thumbnail box-shadow" style="zoom: 50%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
				</a>
				<p id="milestone-pagetitle" class="text-success margin-top25"></p>
			</div>
			<div class="modal-footer" style="text-align: center; background: #E6E9ED">
				<button type="button" class="btn btn-primary" data-dismiss="modal">
					<span><i class="fa fa-close"></i></span>
					閉じる
				</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$( ".month-select" ).change(function() {
		$( ".month-form" ).submit();
	});
</script>
<?php //echo Asset::js('style.js'); ?>
