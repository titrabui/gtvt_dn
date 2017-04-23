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
										<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#measuringValueModal" data-whatever="<?php echo Uri::create("admin/measuring_values/delete/".$onecase['id'].'?measuring_point='.$onecase['measuring_point_id']).','.str_replace(',', '', $measuring_points['name']).','.Date::forge($onecase['created_at'])->format("%d - %m - %Y").','.Date::forge($onecase['created_at'])->format("%H : %M : %S"); ?>">
											<i class="fa fa-trash"></i>
											<span>Xóa</span>
										</button>
									</td>
									<td class="text-center"><?php echo $no_counter++; ?></td>
									<td><?php echo Date::forge($onecase['created_at'])->format("%d - %m - %Y"); ?></td>
									<td><?php echo Date::forge($onecase['created_at'])->format("%H : %M : %S"); ?></td>
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
<div class="row">
	<div class="col-md-12">
		<!-- LINE CHART -->
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Line Chart</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="chart">
					<canvas id="lineChart" style="height: 250px; width: 510px;" height="250" width="510"></canvas>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
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
<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChart = new Chart(areaChartCanvas);

    var areaChartData = {
      labels: ["January", "February", "March", "April", "May", "June", "July"],
      datasets: [
        {
          label: "Electronics",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [65, 59, 80, 81, 56, 55, 40]
        },
        {
          label: "Digital Goods",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [28, 48, 40, 19, 86, 27, 90]
        }
      ]
    };

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = areaChartOptions;
    lineChartOptions.datasetFill = false;
    lineChart.Line(areaChartData, lineChartOptions);
  });
</script>