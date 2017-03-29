<div class="row">
	<div class="col-lg-12 col-md-6 box-layout">
		<!-- small box -->
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-tasks"></i></span>
				DỰ ÁN
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<?php $pagina_counter = Pagination::instance('projects_pagination'); ?>
					<?php $no_counter = (($pagina_counter->current_page - 1) * $pagina_counter->per_page) + 1; ?>
					<table class="table table-hover">
						<thead>
							<tr class="tbl-header">
								<th class="text-center">STT</th>
								<th>Dự án</th>
								<th>Địa điểm</th>
								<th>Chủ đầu tư</th>
								<th>Ghi chú</th>
								<th class="edit-route"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($projects as $onecase) { ?>
								<tr>
									<td class="text-center"><?php echo $no_counter++; ?></td>
									<td><?php echo Str::truncate($onecase['name'], 80); ?></td>
									<td><?php echo Str::truncate($onecase['location'], 80); ?></td>
									<td><?php echo Str::truncate($onecase['investor'], 80); ?></td>
									<td><?php echo Str::truncate($onecase['note'], 80); ?></td>
									<td class="edit-route pull-right">
										<a class="btn btn-sm btn-primary" href="<?php echo Uri::create("user/measuring_points/view/".$onecase['id']); ?>">
											<i class="fa fa-exchange"></i>
											<span>Xem</span>
										</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div> <!-- table-responsive /-->
				<?php if (count($projects) == 0) { ?>
					<div class="row text-center">Không có dữ liệu</div>
				<?php } ?>
				<div class="row text-center"><?php echo html_entity_decode($pagination); ?></div>
			</div>
		</div>
	</div>
</div>
