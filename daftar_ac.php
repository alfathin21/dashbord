<!DOCTYPE html>

<?php

  include 'config/connect.php';
 ?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>TLP Report - Daftar Pesawat</title>

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

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">

    <script src="assets/js/chart-master/Chart.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->

      <?php
        $page_now = "daftar_ac";
        include 'header.php';
       ?>

      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->

      <?php
        include 'navbar.php';
       ?>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content" style="min-height:94vh;">
        <section class="wrapper" style="text-align: centered">
          <h3><i class="fa fa-angle-right"></i> Daftar A/C</h3>
        <div class="row mt">
          <div class="col-lg-12">
                    <div class="content-panel">
                    <h4><i class="fa fa-angle-right"></i> List A/C</h4>
                        <section id="unseen">
                          <table class="table table-bordered table-striped table-condensed" style="text-align: center">
                            <thead style="text-align: center">
                            <tr>
                                <th>Id</th>
                                <th>A/C Type</th>
                                <th class="numeric">Edit</th>
                            </tr>
                            </thead>
            <tbody>
    			<?php
            $sql_ac = "SELECT ac_id, ac_name FROM tblac_type";

    				$res_ac = mysqli_query($link, $sql_ac);

    				//print_r($sql_delay);

    				while ($rowes = $res_ac->fetch_array(MYSQLI_NUM)) {
    					echo "<tr>";
    						echo "<td>".$rowes[0]."</td>"; //Id pesawat
    						echo "<td>".$rowes[1]."</td>"; //AcType
                echo '  <td>';
                echo '  <a href="update_product.php?id='.$rowes[0].'" class="btn btn-default left-margin">Edit</a>';
                echo '  <a delete-id="'.$rowes[0].'" class="btn btn-danger delete-object">Delete</a>';
                echo '  </td>';
    					echo "</tr>";
    				}

    			 ?>


            </tbody>
    			</table>

          </section>
        </div>
      </div>
    </div>

      </section>
    </section>

<?php
  include 'footer.php';
 ?>

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>

    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
	<script src="assets/js/zabuto_calendar.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    $('#table_delay').DataTable({
      dom: 'Bfrtip',
      buttons: [
          'copyHtml5',
          'excelHtml5',
          'pdfHtml5'
      ]
    });

  } );
  </script>

  </body>
</html>
