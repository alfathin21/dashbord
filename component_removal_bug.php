<!DOCTYPE html>

<?php

//Mendapatkan Value yang di passing
if(empty($_POST["actype"])){
  $ACType = "";
}
else{
  $ACType = "'".$_POST['actype']."'";
}
if(empty($_POST["acreg"])){
  $ACReg = "";
}
else{
  $ACReg = $_POST['acreg'];
}
if(empty($_POST["part_no"])){
  $PartNum = "";
}
else{
  $PartNum = "".$_POST['part_no']."";
}
if(!empty($_POST["datefrom"])){
  $DateStart = "".$_POST['datefrom']."";
}
else{
  $DateStart = "";
}
if(!empty($_POST["dateto"])){
  $DateEnd = "".$_POST['dateto']."";
}
else
  $DateEnd = "";

  include 'config/connect.php';
 ?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>TLP Report - Component Removal</title>

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
    <link rel-"stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
      include 'loader_style.php';
    ?>
  </head>

  <body onload="myFunction()" style="margin:0;">

    <?php
        include 'loader.php';
      ?>

    <div style="display:none;" id="myDiv" class="animate-bottom">

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->

      <?php
        $page_now = "component";
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
          <div class="col-md-12 mt">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4><i class="fa fa-angle-right"></i> Filter Component Trend</h4>
              </div>
              <div class="panel-body">
                <?php
                  include 'form_component.php';
                ?>
              </div>
            </div>
          </div>

      <!-- Ini isi tabel -->
      <!-- Tabel Component Removal -->

      <br>
      <br>
      <div class="col-md-12 mt">
        <div class="content-panel">
<!--
            <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
            <table id="comp_table" class="displayr" cellspacing="0" width="100%">\

          <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
          <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
          <div class="adv-table">
              <table id="comp_table" class="table table-hover">
              -->
              <h4><i class="fa fa-angle-right"></i> Tabel</h4>
              <section id="unseen" style="padding: 10px">
              <table id="comp_table" class="table table-bordered table-striped table-condensed">
                <hr>
                    <thead>
                    <tr>
                        <th>Notification</th>
                        <th>ATA</th>
                        <th>Equipment</th>
                        <th>Part Number</th>
                        <th>Serial Number</th>
                        <th>Part Name</th>
                        <th>Register</th>
                        <th>A/C Type</th>
                        <th>Rem Code</th>
                        <th>Real Reason</th>
                        <th>Date Removal</th>
                        <th>TSN</th>
                        <th>TSI</th>
                        <th>CSN</th>
                        <th>CSI</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
/*
          //                  echo "Sebelum: ".$DateStart;
          //                  echo "<br>";

                    $Date_temp = explode("-", $DateStart);
                    $DateStart = $Date_temp[0].$Date_temp[1];

                    $Date_temp = explode("-", $DateEnd);
                    $DateEnd =$Date_temp[0].$Date_temp[1];

                    echo "Month date :". $MonthDate[0].$MonthDate[1]."<br>";

                    echo "Terbaruuu : ".$DateStart;
                    echo "<br>";
                    */

                    $sql_rem = "SELECT ID, ATA, AIN, PartNo, SerialNo, PartName, Reg, Aircraft, RemCode, `Real Reason`, DateRem, TSN, TSI, CSN, CSI
                            FROM tblcompremoval WHERE Aircraft = ".$ACType." AND PartNo LIKE '%".$PartNum."%' AND Reg LIKE '%".$ACReg."%' AND DateRem BETWEEN '".$DateStart."' AND '".$DateEnd."'";
/*
                      if(!empty($RemCode[1])){
                        $sql_rem = "SELECT ID, ATA, AIN, PartNo, SerialNo, PartName, Reg, Aircraft, MONTH, Qty, RemCode, Reason, 'Real Reason', DateRem, TSN, TSI, CSN, CSI
                                FROM tblcompremoval WHERE Aircraft = ".$ACType." AND PartNo LIKE '%".$PartNum."%'AND MONTH BETWEEN ".$DateStart." AND ".$DateEnd."";
                      }
                      if(!empty($RemCode[0])){
                        if ($RemCode[0] == "D") {
                          $sql_rem = "SELECT ID, ATA, AIN, PartNo, SerialNo, PartName, Reg, Aircraft, MONTH, Qty, RemCode, Reason, 'Real Reason', DateRem, TSN, TSI, CSN, CSI
                                  FROM tblcompremoval WHERE Aircraft = ".$ACType." AND PartNo LIKE '%".$PartNum."%'AND MONTH BETWEEN ".$DateStart." AND ".$DateEnd."";
                        }
                        else if ($RemCode[0]=="W") {
                          $sql_rem = "SELECT ID, ATA, AIN, PartNo, SerialNo, PartName, Reg, Aircraft, MONTH, Qty, RemCode, Reason, 'Real Reason', DateRem, TSN, TSI, CSN, CSI
                                  FROM tblcompremoval WHERE Aircraft = ".$ACType." AND PartNo LIKE '%".$PartNum."%'AND MONTH BETWEEN ".$DateStart." AND ".$DateEnd."";
                        }
                      }
                      else {
                        $sql_rem = "SELECT ID, ATA, AIN, PartNo, SerialNo, PartName, Reg, Aircraft, MONTH, Qty, RemCode, Reason, 'Real Reason', DateRem, TSN, TSI, CSN, CSI
                                FROM tblcompremoval WHERE Aircraft = ".$ACType." AND PartNo LIKE '%".$PartNum."%'AND MONTH BETWEEN ".$DateStart." AND ".$DateEnd."";
                      }
                      */

                      $res_rem = mysqli_query($link, $sql_rem);

                      //print_r($sql_rem);

                      while ($rowes = $res_rem->fetch_array(MYSQLI_NUM)) {
                        echo "<tr>";
                          echo "<td>".$rowes[0]."</td>"; //ID
                          echo "<td>".$rowes[1]."</td>"; //ATA
                          echo "<td>".$rowes[2]."</td>"; //AIN
                          echo "<td>".$rowes[3]."</td>"; //Part No
                          echo "<td>".$rowes[4]."</td>"; //Serial No
                          echo "<td>".$rowes[5]."</td>"; //Part Name
                          echo "<td>".$rowes[6]."</td>"; //Reg
                          echo "<td>".$rowes[7]."</td>"; //Aircraft
                          echo "<td>".$rowes[8]."</td>"; //Reason
                          echo "<td>".$rowes[9]."</td>"; //Real Reason
                          echo "<td>".$rowes[10]."</td>"; //Date Rem
                          echo "<td>".$rowes[11]."</td>"; //TSN
                          echo "<td>".$rowes[12]."</td>"; //TSI
                          echo "<td>".$rowes[13]."</td>"; //CSN
                          echo "<td>".$rowes[14]."</td>"; //CSI/
                          //echo "<td>".$rowes[5].$rowes[6]."</td>"; //4DigitCode
                        echo "</tr>";
                      }

                     ?>
                    </tbody>
                </table>
              </section>

            </div><! --/content-panel -->
      </div><!-- /col-md-12 -->

      <?php
        $sql_comp = "SELECT DateRem, COUNT(DateRem) AS number_of_rem FROM tblcompremoval
        WHERE Aircraft = ".$ACType." AND PartNo LIKE '%".$PartNum."%' AND Reg LIKE '%".$ACReg."%' AND DateRem BETWEEN '".$DateStart."' AND '".$DateEnd."' GROUP BY DateRem;";

        print_r($sql_comp);
        $res_comp = mysqli_query($link, $sql_comp);

        $i = 0;
        while($rowes = $res_comp->fetch_array(MYSQLI_NUM)){
          if($i>10) break;
          $arr_comp[$i][0] = $rowes[0];
          $arr_comp[$i][1] = $rowes[1];
          $i++;
        }

       ?>

      <div class="col-md-12 mt">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4><i class="fa fa-angle-right"></i>Grafik Component Removal</h4>
          </div>
          <div class="panel-body">
              <div id="grafik_comp" style="height: 250px; margin-top: 50px"></div>
          </div>
        </div>
      </div>

      <script type="text/javascript">
      new Morris.Line({
        element: 'grafik_comp',
        data: [
          { y: '2006', a: 100, b: 90 },
          { y: '2007', a: 75,  b: 65 },
          { y: '2008', a: 50,  b: 40 },
          { y: '2009', a: 75,  b: 65 },
          { y: '2010', a: 50,  b: 40 },
          { y: '2011', a: 75,  b: 65 },
          { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B']
      });

      </script>


    </section>
  </section>

          <!--End of table-->
          <!--
    			<script src="//code.jquery.com/jquery-1.12.4.js"></script>
    			<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    			<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    			<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
    			<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    			<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    			<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    			<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    			<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>

        -->


                  <!-- Grafik-->



<?php
  include 'footer.php';
 ?>


  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <!--
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>

      <script src="//code.jquery.com/jquery-1.12.4.js"></script>

    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
-->
  <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
  <script src="http:////cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>

  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<!--
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
-->
    
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

  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
  <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#comp_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5', 'pdfHtml5'
            //'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        responsive: true
      });
  });
  </script>

  </body>
</html>
