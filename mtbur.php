<!DOCTYPE html>

<?php
	include "config/connect.php";
	include 'jsonwrapper.php';

	$ACType = "'%".$_POST["actype"]."%'";
	if(empty($_POST["partnumber"])){
		$PartNo = "";
	}
	else{
		$PartNo = " AND PartNo LIKE '%".$_POST['partnumber']."%'";
	}
	if(empty($_POST["monthfrom"])){
		$MonthStart = "";
		$MonthStart2 = "";
	}
	else{
		$month = $_POST['monthfrom'];
		$months = explode("/", $month);
		$month = $months[1]."-".$months[0]."-"."01";
		$month1 = $months[1]."".$months[0];
		$MonthStart = " AND MonthEval BETWEEN '".$month."'";
		$MonthStart2 = " AND Month BETWEEN '".$month1."'";
	}
	if(empty($_POST["monthto"])){
		$MonthEnd = "";
		$MonthEnd2 = "";
	}
	else{
		$month = $_POST['monthto'];
		$months = explode("/", $month);
		$month = $months[1]."-".$months[0]."-"."01";
		$month1 = $months[1]."".$months[0];
		$MonthEnd = " AND '".$month."'";
		$MonthEnd2 = " AND '".$month1."'";
	}

	$sql_fh = "SELECT RevFHHours, RevFHMin FROM tbl_monthlyfhfc WHERE Actype LIKE ".$ACType."".$MonthStart."".$MonthEnd;

	$sql_rm = "SELECT COUNT(Aircraft) AS rem FROM tblcompremoval WHERE Aircraft LIKE ".$ACType."".$PartNo."".$MonthStart2."".$MonthEnd2." AND RemCode = 'U'";

	$sql_qty = "SELECT DateRem, PartNo, QTY FROM tblcompremoval WHERE Aircraft LIKE ".$ACType."".$PartNo."".$MonthStart2."".$MonthEnd2." AND RemCode = 'U' ORDER BY DateRem DESC LIMIT 1";

	$sql_tbl = "SELECT DateRem, PartNo, SerialNo, PartName, Reg FROM tblcompremoval WHERE Aircraft LIKE ".$ACType."".$PartNo."".$MonthStart2."".$MonthEnd2." AND RemCode = 'U'";
	
	mysqli_set_charset($link, "utf8");
	$res_fh = mysqli_query($link, $sql_fh);
	$res_rm = mysqli_query($link, $sql_rm);
	$res_qty = mysqli_query($link, $sql_qty);
	$res_tbl = mysqli_query($link, $sql_tbl);
	$fhours = 0;
	while ($rowes = $res_fh->fetch_array(MYSQLI_NUM)) {
		$rowes[1] = $rowes[1]/60;
		$fhours = $fhours+$rowes[0]+$rowes[1];
	}
?>

<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Reliability Dashboard - MTBUR</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <?php  
      include 'loader_style.php';
    ?>

</head>

<body onload="myFunction()">

	<?php  
      include 'loader.php';
    ?>

  	<div style="display:none;" id="myDiv" class="animate-bottom">

  		<section id="container" >

			<?php
				$page_now = "mtbur";
				include 'header.php';
			?>

			<?php
				include 'navbar.php';
			?>

			<section id="main-content" style="min-height:94vh;">
				<section class="wrapper" style="text-align: centered">

					<div class="col-md-12 mt">
        				<div class="panel panel-default">
        					<div class="panel-heading">
        						<h4><i class="fa fa-angle-right"></i> Filter MTBUR</h4>
        					</div>
        					<div class="panel-body">
        						<?php
									include "input_mtbur_n.php";
								?>
        					</div>
        				</div>
        			</div>

					<div class="col-md-12 mt">
        				<div class="panel panel-default">
        					<div class="panel-heading">
        						<h4><i class="fa fa-angle-right"></i> Data MTBUR</h4>
        					</div>
        					<div class="panel-body">
	        					<label class="col-sm-1 control-label">FH</label>
								<div class="col-sm-2">
									<?php  
											echo number_format($fhours, 2, '.', ',');
										?>
								</div><br><br>
								<label class="col-sm-1 control-label">Removal</label>
								<div class="col-sm-2">
									<?php
											$rms = $res_rm->fetch_array(MYSQLI_NUM);
											$rm = $rms[0];
											echo "$rm";
										?>
								</div><br><br>
								<label class="col-sm-1 control-label">MTBUR</label>
								<div class="col-sm-2">
									<?php
											if($rm != 0){
												$qtys = $res_qty->fetch_array(MYSQLI_NUM);
												$qty = $qtys[2];
												$mtbur = $fhours*$qty/$rm;
												echo number_format($mtbur, 0, '.', ',');
											}
											else{
												echo "N\A";
											}
										?>
								</div><br><br>
								<!-- <label class="col-sm-1 control-label">Perhitungan MTBUR</label>
								<div class="col-sm-2">
									<?php  
										print_r($fhours); echo "*"; print_r($qty); echo "/"; print_r($rm);
									?>
								</div><br><br> -->
        					</div>
        				</div>
        			</div>
					

					<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
					<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
					<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
					<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
					<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
					<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
					<div class="col-md-12 mt">
        				<div class="panel panel-default">
        					<div class="panel-heading">
        						<h4><i class="fa fa-angle-right"></i> Table MTBUR</h4>
        					</div>
        					<div class="panel-body" style="padding: 10px">
        						<button id="exportButton" onclick="generate()" type="button" class="btn btn-default pull-left" style="margin-bottom: 10px">Export as PDF</button>
        						<table id="table_mtbur" class="table table-bordered table-striped table-condensed">
								        <thead>
								            <tr>
								            	<th>Date Removal</th>
								                <th>Part Number</th>
								                <th>Serial Number</th>
								                <th>Part Name</th>
								                <th>Reg</th>
								            </tr>
								        </thead>
								        <tbody>
											<?php
												$arr_mtbur = array();
												while ($rowes = $res_tbl->fetch_array(MYSQLI_NUM)) {
													$arr_mtbur[] = $rowes;
													echo "<tr>";
														echo "<td>".$rowes[0]."</td>";
														echo "<td>".$rowes[1]."</td>";
														echo "<td>".$rowes[2]."</td>";
														echo "<td>".$rowes[3]."</td>";
														echo "<td>".$rowes[4]."</td>";
													echo "</tr>";
												}
										 	?>
									</tbody>
								</table>
        					</div>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function() {
					$('#table_mtbur').DataTable({
						"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
						dom: 'Blfrtip',
						buttons: [{
						  extend : 'excelHtml5', text: 'Export As Excel', className: 'btn btn-default'
						}],
					});
				} );
				</script>

				<script src="js/jspdf.min.js"></script>
		          <script src="js/jspdf.plugin.autotable.js"></script>
		          <script type="text/javascript">
		            // this function generates the pdf using the table
		            function generate() {
		              datatableLength = -1;
		              var fhour = <?php echo(json_encode(number_format($fhours, 2, '.', ','))); ?>;
		              var rm = <?php echo(json_encode($rm)); ?>;
		              var mtbur = <?php echo(json_encode(number_format($mtbur, 0, '.', ','))); ?>;
		              var data = <?php echo(json_encode($arr_mtbur)); ?>;
		              var pdfsize = 'a4';
		              var columns = ["Date Removal", "Part Number", "Serial Number", "Part Name", "Reg"];
		              //var data = tableToJson($("#table_mtbur").get(0), columns);
		              console.log(data);
		              var doc = new jsPDF('l', 'pt', pdfsize);
		              doc.text(40, 40, "FH");
		              doc.text(40, 70, "Removal");
		              doc.text(40, 100, "MTBUR");
		              doc.text(140, 40, fhour);
		              doc.text(140, 70, rm);
		              doc.text(140, 100, mtbur);
		              doc.autoTable(columns, data, {
		                theme: 'grid',
		                styles: {
		                  overflow: 'linebreak'
		                },
		                startY: 120,
		                margin: {top: 40},
		                tableWidth: 'auto'
		              });
		              doc.save("table.pdf");
		            }
		            // This function will return table data in an Array format
		            function tableToJson(table, columns) {
		              var data = [];
		              // go through cells
		              for (var i = 1; i < table.rows.length; i++) {
		                var tableRow = table.rows[i];
		                var rowData = [];
		                for (var j = 0; j < tableRow.cells.length; j++) {
		                  rowData.push(tableRow.cells[j].innerHTML)
		                }
		                data.push(rowData);
		              }
		                
		              return data;
		            }
		          </script>

				</section>
			</section>

			<?php
				include 'footer.php';
			?>

		</section>
	</div>
</body>
</html>