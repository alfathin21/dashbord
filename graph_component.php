<!DOCTYPE html>

<?php

//Mendapatkan Value yang di passing
if(empty($_POST["actype"])){
  $ACType = "";
  $where_actype = "";
}
else{
  $ACType = "'".$_POST['actype']."%'";
  $where_actype = "AND Aircraft LIKE ".$ACType;
}
if(empty($_POST["acreg"])){
  $ACReg = "";
}
else{
  $ACReg = $_POST['acreg'];
}
if(empty($_POST["part_no"])){
  $PartNum = "";
  $where_part = "";
  $need_table = 1;
}
else{
  $PartNum = "'".$_POST['part_no']."%'";
  $where_part = "AND PartNo LIKE '".$_POST['part_no']."%'";
  $need_table = 0;
}
if(!empty($_POST["datefrom"])){
  $temp_date = explode('/', $_POST['datefrom']);
  $DateStart = $temp_date[2]."-".$temp_date[1]."-".$temp_date[0];
//  $DateStart = date("Y-d-m", strtotime($_POST['datefrom']));
}
else{
  $DateStart = "";
}
if(!empty($_POST["dateto"])){
  $temp_date = explode('/', $_POST['dateto']);
  $DateEnd = $temp_date[2]."-".$temp_date[1]."-".$temp_date[0];
//  $DateEnd = date("Y-d-m", strtotime($_POST['dateto']));
}
else
  $DateEnd = "";

if(!empty($_POST["remcode"])){
  $data = implode("','",$_POST["remcode"]);
  $where_remcode = "AND RemCode IN ('$data')";

  $i = 0;
  foreach ($_POST['remcode'] as $val) {
    $RemCode[$i] = $val;
    $i++;
  }
}
else {
  $where_remcode = "";
}


/*====================================================================================================
  Connect.php sebagai php yang menghubunkan script ke database
  jsonwrapper.php sebagai pelengkap, karena php versi server tidak dapat mengenali fungsi json_encode
  ====================================================================================================
*/
  include 'config/connect.php';
  include 'jsonwrapper.php';
 ?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Aircraft Reliability - Component Removal</title>

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

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php

    /*====================================================================================================
      loader_style.php yang berisi link menuju css yang digunakan untuk loading screen

      fungsi onload myfunction() terletak pada loader.php yang berfungsi untuk menjalankan loading screen
      ====================================================================================================
    */
      include 'loader_style.php';
    ?>
</head>

<body onload="myFunction()" style="margin:0;">

    <?php

    /*====================================================================================================
      loader.php berisikan tentang fungsi untuk menjalankan loading screen

      loading hanya bekerja pada div dengan id="myDiv" saja
      ====================================================================================================
    */
      include 'loader.php';
    ?>


    <div style="display:none;" id="myDiv" class="animate-bottom">

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->

      <?php
      /*====================================================================================================
        header.php adalah bagian atas website yang berisi toggle menu, logo, dan tulisan "Home"
        $page_now sebagai penunjuk lokasi halaman terkini
        ====================================================================================================
      */
        $page_now = "pareto_comp";
        include 'header.php';
       ?>

      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->

      <?php
      /*====================================================================================================
        navbar.php adalah bagian kiri website yang berisi daftar halaman yang tersedia dan menunjukkan dimana
        posisi user terkini
        ====================================================================================================
      */
        include 'navbar.php';
       ?>

       <?php

          $sql_graph_comp = "SELECT PartNo, PartName, COUNT(PartNo) AS number_of_part
          FROM tblcompremoval WHERE DateRem BETWEEN '".$DateStart."' AND '".$DateEnd."' ".$where_actype."".$where_remcode." GROUP BY PartNo ORDER BY number_of_part DESC";

          /*====================================================================================================
            Menquery sql yang telah disiapkan dan hasilnya disimpan dalam $res_graph_comp
            Query akan menampilkan jumlah kejadian component removal pada kriteria sesuai filter dan telah diurutkan
            berdasarkan jumlah kejadian

            untuk memastikan bahwa ada data yang terambil, maka dilakukan perhitungan hasil yang disimpan dalam
            $row_cnt untuk jumlah row pada hasil query $res_graph_comp
            ====================================================================================================
          */

          $res_graph_comp = mysqli_query($link, $sql_graph_comp);

          $row_cnt = mysqli_num_rows($res_graph_comp);

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
                <h4><i class="fa fa-angle-right"></i>Filter Component Removal Criteria</h4>
              </div>
              <div class="panel-body">
                <?php
                /*====================================================================================================
                  form_pareto_comp.php berisikan filter pareto component removal yang harus diisi user untuk menampilkan
                  data component removal yang sesuai
                  ====================================================================================================
                */
                  include 'form_pareto_comp.php';
                ?>
              </div>
            </div>
          </div>

      <div class="col-md-12 mt">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4><i class="fa fa-angle-right"></i>Top 10 Component Removal</h4>
          </div>
          <div class="panel-body">
            <?php
              if($row_cnt>0){
                echo "<canvas id='grafik_pareto' style='height: 250px; margin-top: 50px'></canvas>";
              }
              else {
                echo "<h2>Tidak ada data</h2>";
              }

             ?>
          </div>
        </div>
      </div>

      <div class="col-md-12 mt">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4><i class="fa fa-angle-right"></i>Definition Table</h4>
          </div>
          <div class="panel-body">
              <section id="unseen" style="padding: 10px">
              <table id="comp_table" class="table table-bordered table-striped table-condensed">
                <button id="exportButton" onclick="generate()" type="button" class="btn btn-default pull-left"><i class="fa fa-print"></i> Export as PDF</button>
                <br>
                <br>
                <br>
                    <thead>
                    <tr>
                      <?php
                        if($row_cnt>0){
                          echo "<th>No</th>";
                          echo "<th>Code</th>";
                          echo "<th>Part Name</th>";
                        }
                       ?>

                    </tr>
                    </thead>
                    <tbody>

                    <?php

                      $arr_pareto = Array();

                      $i = 0;
                      $num = 1;

                      /*====================================================================================================
                        Apabila ada data, maka data tersebut akan ditampilkan dalam tabel untuk mendefinisikan kode part
                        dan nama dari part tersebut

                        Selagi mengisi tabel, data tersebut disimpan dalam $arr_pareto
                        ====================================================================================================
                      */

                      if($row_cnt > 0){
                        while ($rowes = $res_graph_comp->fetch_array(MYSQLI_NUM)) {
                          if($i > 9) break;
                          echo "<tr>";
                            echo "<td>".$num."</td>"; //No
                            echo "<td>".$rowes[0]."</td>"; //Code
                            echo "<td>".$rowes[1]."</td>"; //Part Name
                          echo "</tr>";
                          $arr_pareto[$i][0] = $rowes[0]; //Code
                          $arr_pareto[$i][1] = $rowes[1]; //Part Name
                          $arr_pareto[$i][2] = $rowes[2]; //Jumlah
                          $i++;
                          $num++;
                        }
                      }
                      else {
                        echo "<tr>";
                          echo "<h3>Tidak ada data</h3>";
                        echo "</tr>";
                      }

                      //print_r($sql_rem);
                     ?>
                    </tbody>
                </table>
              </section>
            </div>
          </div><!--/content-panel -->
      </div><!-- /col-md-12 -->

      </section>
    </section>

<?php
  include 'footer.php';
 ?>

  </section>

    <!-- js placed at the end of the document so the pages load faster -->

    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>

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

  <script src="js/jspdf.min.js"></script>
  <script src="js/jspdf.plugin.autotable.js"></script>
  <script type="text/javascript">
    // this function generates the pdf using the table
    function generate() {
      var pdfsize = 'a4'; //Ukuran PDF
      var columns = ["No", "Code", "Name"]; //Nama kolom yang akan diekspor
      var data = tableToJson($("#comp_table").get(0), columns); // Tabel yang akan diekspor
      console.log(data);
      var canvas = document.querySelector('#grafik_pareto'); // Grafik yang akan di ekspor
      var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
      var doc = new jsPDF('l', 'pt', pdfsize);
      var width = doc.internal.pageSize.width;
      doc.autoTable(columns, data, {
        theme: 'grid',
        styles: {
          overflow: 'linebreak'
        },
        pageBreak: 'always',
        tableWidth: 'auto'
      });
      let finalY = doc.autoTable.previous.finalY;
      doc.addPage();
      doc.addImage(canvasImg, 'JPEG', 40, 40, width-80, 400);
      doc.save("Pareto Component.pdf");
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

  <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script type="text/javascript" src="js/Chart.min.js"></script>

  <!-- TOP 10 Component Removal -->
  <script type="text/javascript">
  var part_no = [];
  var jumlah_comp = [];
  var z=0;

  var arr_comp = <?php echo json_encode($arr_pareto); ?>;

  for ( tot=arr_comp.length; z < tot; z++) {
     part_no.push(arr_comp[z][0]);
     jumlah_comp.push(arr_comp[z][2]);
  };

  Chart.plugins.register({
    beforeDraw: function(chartInstance) {
      var ctx = chartInstance.chart.ctx;
      ctx.fillStyle = "white";
      ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
    }
  });

  var ctx = document.getElementById("grafik_pareto").getContext("2d");

  var data = {
    labels: part_no,
    datasets: [{
      label: "Number of Component Removal",
      backgroundColor: "red",
      strokeColor: "black",
      data: jumlah_comp
    }]
  };

  var options = {
    title : {
      display : true,
      position : "top",
      text : "Top 10 Component Removal",
      fontSize : 18,
      fontColor : "#111"
    },
    legend : {
      display : true,
      position : "bottom"
    },
    scales: {
          yAxes: [{
            scaleLabel: {
                display: true,
                labelString: 'Number'
              },
              ticks: {
                  beginAtZero: true
              }
          }]
      }
  };

  var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: options
  });
  </script>

    </div>
  </body>
</html>
