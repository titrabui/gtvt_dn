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
						<span>TẠO MỚI</span>
					</a>
				</div>
				<hr>
				<div class="table-responsive">
					<?php $pagina_counter = Pagination::instance('projects_pagination'); ?>
					<?php $no_counter = (($pagina_counter->current_page - 1) * $pagina_counter->per_page) + 1; ?>
					<table class="table table-hover">
						<thead>
							<tr class="tbl-header">
								<th class="no">NO</th>
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
									<td class="no"><?php echo $no_counter++; ?></td>
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
											<span>Chỉnh sửa</span>
										</a>
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
				<?php if (count($projects) == 0) { ?>
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
<?php //echo Asset::js('style.js'); ?>
