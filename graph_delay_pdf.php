<!DOCTYPE html>
<?php 
  $res_delay[] = $_POST["data_table"];
  print_r($res_delay);
?>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

  <title>TLP Report - Graph</title>

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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>
<body>
  <div style="display:none;" id="myDiv" class="animate-bottom">
    <section id="main-content" style="min-height:94vh;">
          <section class="wrapper" style="text-align: centered">
            <section id="container">
            <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
                <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
                <div class="col-md-12 mt" id="table_print">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4><i class="fa fa-angle-right"></i> Table Delay</h4>
                    </div>
                    <div class="panel-body">
                      <table id="table_delay" class="display cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>A/C Type</th>
                                <th>A/C Reg</th>
                                <th>Sta Dep</th>
                                <th>Sta Arr</th>
                                <th>Flight No</th>
                                <th>Delay Length</th>
                                <th>ATA</th>
                                <th>Sub ATA</th>
                                <th>Problem</th>
                                <th>Rectification</th>
                                <th>DCP</th>
                                <th>RTB/RTA/RTO</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>A/C Type</th>
                                <th>A/C Reg</th>
                                <th>Sta Dep</th>
                                <th>Sta Arr</th>
                                <th>Flight No</th>
                                <th>Technical Delay Length</th>
                                <th>ATA</th>
                                <th>Sub ATA</th>
                                <th>Problem</th>
                                <th>Rectification</th>
                                <th>DCP</th>
                                <th>RTB/RTA/RTO</th>
                            </tr>
                        </tfoot>
                        <tbody>
                          <?php
                            while ($rowes = $res_delay->fetch_array(MYSQLI_NUM)) {
                            $rowes[4] = $rowes[4]*60;
                            $rowes[4] = $rowes[4]+$rowes[9];
                            //print_r($rowes[4]);echo "<br>";
                            echo "<tr>";
                              echo "<td>".$rowes[0]."</td>";
                              echo "<td>".$rowes[1]."</td>";
                              echo "<td>".$rowes[2]."</td>";
                              echo "<td>".$rowes[3]."</td>";
                              echo "<td>".$rowes[4]."</td>";
                              echo "<td>".$rowes[5]."</td>";
                              echo "<td>".$rowes[6]."</td>";
                              echo "<td>".$rowes[7]."</td>";
                              echo "<td>".$rowes[8]."</td>";
                              echo "<td>".$rowes[9]."</td>";
                              echo "<td>".$rowes[11]."</td>";
                              echo "<td>".$rowes[12]."</td>";
                            echo "</tr>";
                          }
                         ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
          </section>
        </section>
    </div>

</body>
</html>