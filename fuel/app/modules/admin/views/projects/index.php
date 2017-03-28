<div class="row">
	<div class="col-lg-12 col-md-6 box-layout">
		<!-- small box -->
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<span><i class="fa fa-tasks"></i></span>
				DỰ ÁN
			</div>
			<div class="box-body">
				<div class="text-right">
					<a class="btn btn-md btn-primary" href="<?php echo Uri::create('admin/projects/register'); ?>">
						<i class="fa fa-plus"></i>
						<span>THÊM DỰ ÁN</span>
					</a>
				</div>
				<hr>
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
										<a class="btn btn-sm btn-primary" href="<?php echo Uri::create("admin/measuring_points/view/".$onecase['id']); ?>">
											<i class="fa fa-exchange"></i>
											<span>Xem</span>
										</a>	
										<a class="btn btn-sm btn-warning" href="<?php echo Uri::create("admin/projects/edit/".$onecase['id']); ?>">
											<i class="fa fa-edit"></i>
											<span>Sửa</span>
										</a>
										<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#projectModal" data-whatever="<?php echo Uri::create("admin/projects/delete/".$onecase['id']).','.$onecase['name']; ?>">
											<i class="fa fa-trash"></i>
											<span>Xóa</span>
										</button>
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

<!-- Modal -->
<div class="modal modal-warning" id="projectModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<p class="modal-message">Bạn có chắc chắn muốn xóa dự án này không?</p>
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
<?php echo Asset::js('app/project.js'); ?>
