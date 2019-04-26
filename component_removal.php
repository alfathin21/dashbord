<!DOCTYPE html>

<?php

//Mendapatkan Value yang di passing
if(empty($_POST["actype"])){
  $ACType = "";
}
else{
  $ACType = "'".$_POST['actype']."%'";
  $where_actype = "Aircraft LIKE ".$ACType;
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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

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
        $page_now = "component";
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

        $sql_rem = "SELECT ID, ATA, AIN, PartNo, SerialNo, PartName, Reg, Aircraft, RemCode, `Real Reason`, DateRem, TSN, TSI, CSN, CSI
                FROM tblcompremoval
                WHERE ".$where_actype." AND PartNo LIKE '%".$PartNum."%' AND Reg LIKE '%".$ACReg.
                "%' AND DateRem BETWEEN '".$DateStart."' AND '".$DateEnd."' ".$where_remcode;

      /*====================================================================================================
        Menquery sql yang telah disiapkan dan hasilnya disimpan dalam $res_rem
        Query akan menampilkan jumlah kejadian component removal pada kriteria sesuai filter

        untuk memastikan bahwa ada data yang terambil, maka dilakukan perhitungan hasil yang disimpan dalam
        $row_cnt untuk jumlah row pada hasil query $res_rem
        ====================================================================================================
      */

      mysqli_set_charset($link, "utf8");

      $res_rem = mysqli_query($link, $sql_rem);

      $row_cnt = mysqli_num_rows($res_rem);
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
                <h4><i class="fa fa-angle-right"></i> Filter Component Removal Criteria</h4>
              </div>
              <div class="panel-body">
                <?php
                /*====================================================================================================
                  form_component.php berisikan filter component removal yang harus diisi user untuk menampilkan data
                  component removal yang sesuai
                  ====================================================================================================
                */
                  include 'form_component.php';
                ?>
              </div>
            </div>
          </div>


          <div class="col-md-12 mt">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4><i class="fa fa-angle-right"></i> Tabel Component Removal</h4>
              </div>
              <div class="panel-body">
                  <section id="unseen" style="padding: 10px">
                  <button id="exportButton" onclick="generate()" type="button" class="btn btn-default pull-left"><i class="fa fa-print"></i> Export as PDF</button>
                  <table id="comp_table" class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%">
                    <br>
                    <br>
                    <br>
                        <thead>
                        <tr>
                          <?php
        /*====================================================================================================
          Apabila data hasil query tidak kosong, maka akan menampilkan tabel
          ====================================================================================================
        */
                            if($row_cnt>0){
                              echo "<th>Notification</th>";
                              echo "<th>ATA</th>";
                              echo "<th>Equipment</th>";
                              echo "<th>Part Number</th>";
                              echo "<th>Serial Number</th>";
                              echo "<th>Part Name</th>";
                              echo "<th>Register</th>";
                              echo "<th>A/C Type</th>";
                              echo "<th>Rem Code</th>";
                              echo "<th>Real Reason</th>";
                              echo "<th>Date Removal</th>";
                              echo "<th>TSN</th>";
                              echo "<th>TSI</th>";
                              echo "<th>CSN</th>";
                              echo "<th>CSI</th>";
                            }
                           ?>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
        /*====================================================================================================
          $arr_comp_rem adalah array yang nantinya akan menyimpan data hasil query agar dapat diekspor ke pdf

          apabila ada data, maka akan membuat tabel dengan isi seperti dibawah
          ====================================================================================================
        */
                          //print_r($sql_rem);
                        $arr_comp_rem =array();
                        if($row_cnt>0){
                          while ($rowes = $res_rem->fetch_array(MYSQLI_NUM)) {
                            $arr_comp_rem[] = $rowes;
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
                            echo "</tr>";
                          }
                        }
                        else {
                          echo "<h2>Tidak ada data</h2>";
                        }

                         ?>
                        </tbody>
                    </table>
                  </section>
                </div> <!--Panel body-->
              </div> <!--/content-panel -->
          </div><!-- /col-md-12 -->

    	<?php
      // SQL untuk grafik component removal
      if(isset($where_remcode)){
        $sql_comp = "SELECT DATE_FORMAT(DateRem, '%Y-%m') AS dates, COUNT(DATE_FORMAT(DateRem, '%Y-%m')) AS number_of_rem FROM tblcompremoval
        WHERE ".$where_actype." AND PartNo LIKE '%".$PartNum."%' AND Reg LIKE '%".$ACReg."%' AND DateRem BETWEEN '".$DateStart."' AND '".$DateEnd."' GROUP BY dates;";
      }
      else {
        #$sql_comp = "SELECT DateRem, COUNT(DateRem) AS number_of_rem FROM tblcompremoval
        $sql_comp = "SELECT DATE_FORMAT(DateRem, '%Y-%m') AS dates, COUNT(DATE_FORMAT(DateRem, '%Y-%m')) AS number_of_rem FROM tblcompremoval
        WHERE ".$where_actype." AND ".$where_remcode." AND PartNo LIKE '%".$PartNum."%' AND Reg LIKE '%".$ACReg."%' AND DateRem BETWEEN '".$DateStart."' AND '".$DateEnd."' GROUP BY dates;";
      }

      /*====================================================================================================
        Menquery sql yang telah disiapkan dan hasilnya disimpan dalam $res_comp
        Query akan menampilkan jumlah kejadian component removal pada kriteria sesuai filter per dan dihitung
        per bulan, bukan per kejadian per hari

        karena grafik akan menampilkan data 0, maka perlunya algoritma khusus yang dapat menampilkan data 0
        dan bulan selanjutnya
        ====================================================================================================
      */

      //print_r($sql_rem);

        $res_comp = mysqli_query($link, $sql_comp);

        $graph_cnt = mysqli_num_rows($res_comp);

        $temp_arr_comp = Array();
        $before_temp = Array();

        $i=0;
        if($graph_cnt > 0){
          while ($rowes = $res_comp->fetch_array(MYSQLI_NUM)) {
            $temp_arr_comp[$i][0] = $rowes[0];
            $temp_arr_comp[$i][1] = $rowes[1];
            $i++;
          }

          $i = 0;
          $temp_arr = 0;
          $now = strtotime($DateStart);
          $end_date = strtotime($DateEnd);

          $end_date = strtotime("+1 Month", $end_date);

          while (date("Y-m" ,$now) != date("Y-m" ,$end_date)) {

              //Apabila Bulan dan tahun sekarang sama dengan bulan dan tahun pada tabel hasil query, maka hasilnya akan disimpan
              //dalam array
              if($temp_arr_comp[$temp_arr][0] == date("Y-m", $now)){
                $arr_comp[$i][0] = $temp_arr_comp[$temp_arr][0];
                $arr_comp[$i][1] = $temp_arr_comp[$temp_arr][1];
                if($temp_arr < $graph_cnt-1)
                  $temp_arr++;
                $i++;
              }

              //Apabila masih tidak sama, berarti menyimpan jumlah kejadian 0 ke dalam array
              else {
                //Selama bulan dan tahun ke $now masih belum ada kejadian, maka akan diisi 0 hingga menemukan
                //tahun dan bulan selanjutnya
                $arr_comp[$i][0] = date("Y-m", $now);
                $arr_comp[$i][1] = 0;
                $i++;
              }

            $now = strtotime("+1 Month", $now);
          }
        }

    	 ?>

       <div class="col-md-12 mt">
         <div class="panel panel-default">
           <div class="panel-heading">
             <h4><i class="fa fa-angle-right"></i>Grafik Component Removal</h4>
           </div>
           <div class="panel-body">
             <?php
              if($row_cnt>0){
                echo "<canvas id='grafik_comp' style='height: 250px; margin-top: 50px'></canvas>";
              }
              else {
                echo "<h2>Tidak ada data</h2>";
              }
              ?>

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

  <script type="text/javascript">
    $(document).ready(function() {
      $('#comp_table').DataTable({
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], //Table lenght options
        dom: 'Blfrtip',
        buttons: [{ //Tambahan tombol untuk export ke xls
          extend : 'excelHtml5', text: 'Export As Excel', className: 'btn btn-default'
          }],
        responsive: true
      });
  });
  </script>

  <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script type="text/javascript" src="js/Chart.min.js"></script>

  <script type="text/javascript">
      var label_data = [];
      var jumlah_pirep = [];
      var z=0;

      var arr_pirep = <?php echo json_encode($arr_comp); ?>; //Konversi array php menjadi array JS

      for ( tot=arr_pirep.length; z < tot; z++) {
         label_data.push(arr_pirep[z][0]); //Berisi bulan dan tahun kejadian
         jumlah_pirep.push(arr_pirep[z][1]); //Berisi jumlah kejadian
      };

      Chart.plugins.register({ //Agar saat diekspor pdf, background chart berwarna putih
        beforeDraw: function(chartInstance) {
          var ctx = chartInstance.chart.ctx;
          ctx.fillStyle = "white";
          ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
        }
      });

      //Meletakkan grafik pada div yang memiliki id "grafik_comp"
      var ctx = document.getElementById("grafik_comp").getContext("2d");

      var data = {
        labels: label_data, //berisi bulan dan tahun yang sudah disiapkan
        datasets: [{
          label: "Number of Component Removal In A Month",
          fill: 'false',
          backgroundColor: 'rgba(200, 200, 200, 0)',
          borderColor: 'rgba(0, 0, 255, 1)',
          pointBackgroundColor: 'rgba(255, 0, 0, 1)',
          pointBorderColor: 'rgba(255, 0, 0, 1)',
          lineTension: '0',
          data: jumlah_pirep //berisi jumlah component removal
        }]
      };

      var options = {
        title : {
          display : true,
          position : "top",
          text : "Component Removal",
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
                    labelString: 'Number' //Label di sebelah kiri, untuk memudahkan user membaca grafik
                  },
                  ticks: {
                      beginAtZero: true //agar batas bawah grafik adalah 0
                  }
              }]
          }
      };

      var myBarChart = new Chart(ctx, { //Inisiasi grafik
          type: 'line',
          data: data,
          options: options
      });
  </script>
  <script src="js/jspdf.min.js"></script>
  <script src="js/jspdf.plugin.autotable.js"></script>
  <script type="text/javascript">
    // this function generates the pdf using the table
    function generate() {
      var data = <?php echo json_encode($arr_comp_rem); ?>;
      var pdfsize = 'a4';
      var columns = ["Notification", "ATA", "Equipment", "Part Number", "Serial Number", "Part Name", "Register", "A/C Type", "Rem Code", "Real Reason", "Date Removal", "TSN", "TSI", "CSN", "CSI"];
      console.log(data);
      var canvas = document.querySelector('#grafik_comp');
      var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
      var doc = new jsPDF('l', 'pt', pdfsize);
      var width = doc.internal.pageSize.width;
      doc.autoTable(columns, data, {
        theme: 'grid',
        styles: {
          overflow: 'linebreak',
          fontSize:'6'
        },
        pageBreak: 'always',
        tableWidth: 'auto'
      });
      let finalY = doc.autoTable.previous.finalY;
      doc.addPage();
      doc.addImage(canvasImg, 'JPEG', 40, 40, width-80, 400);
      doc.save("table-component.pdf");
    }
  </script>

    </div>
  </body>
</html>
