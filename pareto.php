<!DOCTYPE html>

<?php

//Mendapatkan Value yang di passing
if(empty($_POST["actype"])){
  $ACType = "";
  $where_actype = "";
}
else{
  $ACType = "'".$_POST['actype']."%'";
  $where_actype = "ACType LIKE '".$_POST['actype']."%'";
}
if(empty($_POST["acreg"])){
  $ACReg = "";
}
else{
  $ACReg = $_POST['acreg'];
}
if(!empty($_POST["datefrom"])){
  $temp_date = explode('/', $_POST['datefrom']);
  $DateStart = "'".$temp_date[2]."-".$temp_date[1]."-".$temp_date[0]."'";
}
else{
  $DateStart = "";
}
if(!empty($_POST["dateto"])){
    $temp_date = explode('/', $_POST['dateto']);
    $DateEnd = "'".$temp_date[2]."-".$temp_date[1]."-".$temp_date[0]."'";
//  $date = str_replace('/', '-', $_POST['dateto']);
//  $DateEnd = "'".date("Y-m-d", strtotime($date))."'";
}
else
  $DateEnd = "";

$Graph_type = $_POST['graph'];

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

    <title>Aircraft Reliability - Pareto</title>

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
        $page_now = "pareto";
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

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content" style="min-height:94vh;">
        <section class="wrapper" style="text-align: centered">
          <div class="col-md-12 mt">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4><i class="fa fa-angle-right"></i> Filter Pareto Criteria</h4>
              </div>
              <div class="panel-body">
                <?php
                /*====================================================================================================
                  form_pareto.php berisikan filter pareto yang harus diisi user untuk menampilkan data pareto yang
                  sesuai
                  ====================================================================================================
                */
                  include 'form_pareto.php';
                ?>
              </div>
            </div>
          </div>
    	<?php

      /*====================================================================================================
        $Graph_type ada 3 jenis, didapatkan dari form_pareto.php berbentuk radio button
        maksudnya adalah apabila user menginginkan sumbu X diisi dengan ata, aircraft registration, atau sub-ata
        ====================================================================================================
      */

      if($Graph_type == 'ata' || $Graph_type == 'ac_reg'){
        if($Graph_type == 'ata'){
    			$sql_graph_pirep = "SELECT ata, COUNT(ata) AS number_of_ata FROM tblpirep_swift WHERE ".$where_actype." AND ata >= 21 AND REG LIKE '%".$ACReg."%' AND PirepMarep = 'pirep' AND DATE BETWEEN ".$DateStart." AND ".$DateEnd." GROUP BY ata ORDER BY number_of_ata DESC";
    			$sql_graph_delay = "SELECT ATAtdm, COUNT(Atatdm) AS number_of_ata1 FROM mcdrnew WHERE ".$where_actype." AND DCP <> 'X' AND REG LIKE '%".$ACReg."' AND DateEvent BETWEEN ".$DateStart." AND ".$DateEnd." GROUP BY ATAtdm ORDER BY number_of_ata1 DESC";
    		}
    		else if($Graph_type == 'ac_reg'){
    			$sql_graph_pirep = "SELECT REG, COUNT(REG) AS number_of_reg FROM tblpirep_swift WHERE DATE BETWEEN ".$DateStart." AND ".$DateEnd." AND ata >= 21 AND ".$where_actype." AND REG LIKE '%".$ACReg."%' AND PirepMarep = 'pirep' GROUP BY REG ORDER BY number_of_reg DESC";
    			$sql_graph_delay = "SELECT Reg, COUNT(Reg) AS number_of_reg FROM mcdrnew WHERE ".$where_actype." AND DCP <> 'X' AND REG LIKE '%".$ACReg."' AND DateEvent BETWEEN ".$DateStart." AND ".$DateEnd." GROUP BY REG ORDER BY number_of_reg DESC";
    		}
        /*====================================================================================================
          Menquery sql yang telah disiapkan dan hasilnya disimpan dalam $res_graph_pirep untuk pirep, $res_graph_delay
          untuk Delay
          Query akan menampilkan jumlah kejadian tiap ata, atau registrasi, dan mengurutkan sesuai jumlah tertinggi ke
          rendah

          untuk memastikan bahwa ada data yang terambil, maka dilakukan perhitungan hasil yang disimpan dalam
          $row_delay_cnt untuk jumlah row pada delay dan $row_pirep_cnt unutk jumlah row ppada pirep
          ====================================================================================================
        */
        $res_graph_pirep = mysqli_query($link, $sql_graph_pirep);
    		$res_graph_delay = mysqli_query($link, $sql_graph_delay);

        $row_delay_cnt = mysqli_num_rows($res_graph_delay);
        $row_pirep_cnt = mysqli_num_rows($res_graph_pirep);

        /*====================================================================================================
          Karena hasil query sudah diurutkan, maka hasilnya disimpan pada 10 array dengan ketentuan,
          $arr_pirep[$i][0] akan menyimpan kategori yang dipilih (ata atau nomor registrasi)
          $arr_pirep[$i][1] akan menyimpan jumlah kejadian sesua dengan ata atau nomor registrasi
          ====================================================================================================
        */
    		$i = 0;
    		while ($rowes = $res_graph_pirep->fetch_array(MYSQLI_NUM)) {
    			if($i > 9) break;
    			$arr_pirep[$i][0] = $rowes[0];
    			$arr_pirep[$i][1] = $rowes[1];
    			$i++;
    		}

        /*====================================================================================================
          Karena hasil query sudah diurutkan, maka hasilnya disimpan pada 10 array dengan ketentuan,
          $arr_delay[$i][0] akan menyimpan kategori yang dipilih (ata atau nomor registrasi)
          $arr_delay[$i][1] akan menyimpan jumlah kejadian sesua dengan ata atau nomor registrasi
          ====================================================================================================
        */
    		$i = 0;
    		while ($rowes = $res_graph_delay->fetch_array(MYSQLI_NUM)) {
    			if($i > 9) break;
    			$arr_delay[$i][0] = $rowes[0];
    			$arr_delay[$i][1] = $rowes[1];
    			$i++;
    		}
            //  print_r($sql_graph_pirep);
      }
    	else{
        /*====================================================================================================
          Karena sub ata NULL, 0, dan 00 dianggap 00, maka perlu dilakukan penyamanaan terlebih dahulu
          kedua query ini berfungsi untuk menggabungkan ata-subata, yang mana subata telah diseragamkan menjadi 00
          apabila subata tersebut NULL, 00, atau 0
          ====================================================================================================
        */

          $sql_graph_pirep = "SELECT CASE
            WHEN subata = '0' THEN CONCAT_WS('-',ata, '00')
            WHEN subata = '' THEN CONCAT_WS('-', ata, '00')
            ELSE CONCAT_WS('-', ata, subata)
            END AS ata_subata
            FROM tblpirep_swift WHERE ata >= 21 AND DATE BETWEEN ".$DateStart." AND ".$DateEnd." AND ".$where_actype." AND REG LIKE '%".$ACReg."%' AND PirepMarep = 'pirep'";

          $sql_graph_delay = "SELECT CASE
          	WHEN ISNULL(SubATAtdm) THEN CONCAT_WS('-' ,ATAtdm, '00')
          	WHEN SubATAtdm = '' THEN CONCAT_WS('-' ,ATAtdm, '00')
          	WHEN SubATAtdm = '00' THEN CONCAT_WS('-' ,ATAtdm, '00')
          	WHEN SubATAtdm = '0' THEN CONCAT_WS('-' ,ATAtdm, '00')
          	ELSE CONCAT_WS('-' ,ATAtdm, SubATAtdm)
          	END AS new_ata
            FROM mcdrnew WHERE DCP <>'X' AND ".$where_actype." AND REG LIKE '%".$ACReg."' AND DateEvent BETWEEN ".$DateStart." AND ".$DateEnd."";

            /*====================================================================================================
              Menquery sql yang telah disiapkan dan hasilnya disimpan dalam $res_graph_pirep untuk pirep, $res_graph_delay
              untuk Delay
              Query akan menampilkan jumlah kejadian tiap ata, atau registrasi, dan mengurutkan sesuai jumlah tertinggi ke
              rendah

              untuk memastikan bahwa ada data yang terambil, maka dilakukan perhitungan hasil yang disimpan dalam
              $row_delay_cnt untuk jumlah row pada delay dan $row_pirep_cnt unutk jumlah row ppada pirep
              ====================================================================================================
            */

          $res_graph_pirep = mysqli_query($link, $sql_graph_pirep);
    		  $res_graph_delay = mysqli_query($link, $sql_graph_delay);

          $row_delay_cnt = mysqli_num_rows($res_graph_delay);
          $row_pirep_cnt = mysqli_num_rows($res_graph_pirep);

          /*====================================================================================================
            Apabila jumlah hasil query tidak kosong, maka dilakukan ekstraksi nilai
            hasil disimpan dalam $temp_pirep[$i]
            ====================================================================================================
          */

          //======================================================================Pirep=======================================================

          if($row_pirep_cnt>0){
            $i = 0;
            while ($rowes = $res_graph_pirep->fetch_array(MYSQLI_NUM)) {
              $temp_pirep[$i] = $rowes[0];
              $i++;
            }

            /*====================================================================================================
              Unutk memastikan tidak adanya NULL, maka setiap array yang berisi null akan diisi dengan 0000
              ====================================================================================================
            */

            for($i=0; $i<sizeof($temp_pirep); $i++){
              if($temp_pirep[$i] == NULL){
                $ar[$i] = '0000';
              }
              else {
                $ar[$i] = $temp_pirep[$i];
              }
            }

            /*====================================================================================================
              Fungsi untuk menghitung jumlah kemunculan value tertentu dan hasil kemunculannya disimpan bersama
              value aslinya pada $ar0
              Kemudian mengurutkan array sesuai jumlah kemunculan terbesar ke terkecil dengan fungsi arsort()
              Kemudian menamai setiap array tadi dengan fungsi array_keys yang hasil penamaannya disimpan dalam $keys
              jadi $keys berisi value ata-subata saja

              Lalu ata-subata yang telah didata, dicari jumlahnya
              jumlah kemunculan ada pada $ar0, tetapi kode ata-subata ada pada $keys
              ====================================================================================================
            */

            $ar0 = array_count_values($ar);

            arsort($ar0);

            $keys=array_keys($ar0);//Split the array so we can find the most occuring key

            $arr_pirep = Array();
            for($i=0; $i<10; $i++){
              $arr_pirep[$i][0] = $keys[$i];
              $arr_pirep[$i][1] = $ar0[$keys[$i]];
            }
          }

          //======================================================================Delay=======================================================

          if($row_delay_cnt>0){
        		$i = 0;
        		while ($rowes = $res_graph_delay->fetch_array(MYSQLI_NUM)) {
        			$temp_delay[$i] = $rowes[0];
              $i++;
        		}

            /*====================================================================================================
              Unutk memastikan tidak adanya NULL, maka setiap array yang berisi null akan diisi dengan 0000
              ====================================================================================================
            */

            for($i=0; $i<sizeof($temp_delay); $i++){
              if($temp_delay[$i] == NULL){
                $ar_new[$i] = '0000';
              }
              else {
                $ar_new[$i] = $temp_delay[$i];
              }
            }

            /*====================================================================================================
              Fungsi untuk menghitung jumlah kemunculan value tertentu dan hasil kemunculannya disimpan bersama
              value aslinya pada $ar1
              Kemudian mengurutkan array sesuai jumlah kemunculan terbesar ke terkecil dengan fungsi arsort()
              Kemudian menamai setiap array tadi dengan fungsi array_keys yang hasil penamaannya disimpan dalam $keys
              jadi $keys berisi value ata-subata saja

              Lalu ata-subata yang telah didata, dicari jumlahnya
              jumlah kemunculan ada pada $ar1, tetapi kode ata-subata ada pada $keys
              ====================================================================================================
            */

            $ar1 = array_count_values($ar_new);

            arsort($ar1);

            $keys=array_keys($ar1);//Split the array so we can find the most occuring key

            $arr_delay = Array();
            for($i=0; $i<10; $i++){
              $arr_delay[$i][0] = $keys[$i];
              $arr_delay[$i][1] = $ar1[$keys[$i]];
            }
    		  }
        }

    	 ?>
       <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

       <div class="col-md-12 mt">
         <div class="panel panel-default">
           <div class="panel-heading">
             <h4><i class="fa fa-angle-right"></i>Top 10 Delay</h4>
           </div>
           <div class="panel-body">
             <?php
             /*====================================================================================================
               Apabila ada data,, maka akan memunculkan grafik
               Apabila tidak ada data, akan memunculkan tulisan "Tidak ada data"
               ====================================================================================================
             */
             if($row_delay_cnt > 0){
               echo "<button onclick='generate()' type='button' class='btn btn-default pull-left'><i class='fa fa-print'></i> Export as PDF</button>";
               echo "<canvas id='grafik_delay' style='height: 250px; margin-top: 50px'></canvas>";
             }
             else {
               echo"<h2> Tidak ada data</h2>";
             }
              ?>
           </div>
         </div>
       </div>

       <div class="col-md-12 mt">
         <div class="panel panel-default">
           <div class="panel-heading">
             <h4><i class="fa fa-angle-right"></i>Top 10 Pirep</h4>
           </div>
           <div class="panel-body">
             <?php
             /*====================================================================================================
               Apabila ada data,, maka akan memunculkan grafik
               Apabila tidak ada data, akan memunculkan tulisan "Tidak ada data"
               ====================================================================================================
             */
             if($row_pirep_cnt > 0){
               echo "<canvas id='grafik_pirep' style='height: 250px; margin-top: 50px'></canvas>";
             }
             else {
               echo"<h2> Tidak ada data</h2>";
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

  <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script type="text/javascript" src="js/Chart.min.js"></script>
  <script>

  /*====================================================================================================
    Chart yang kami buat adalah plugin dari ChartJs
    berikut adalah code untuk memasukkan data hasil querry kedalam chart

    label_data berisi label yang sesuai dengan keinginan user di awal, bisa berupa ata, subata, ata-subata
    sedangkan jumlah_delay merupakan jumlah kejadian sesuai dengan label
    ====================================================================================================
  */

  var label_data = [];
  var jumlah_delay = [];
  var z=0;

  var arr_delay = <?php echo json_encode($arr_delay); ?>;

  for ( tot=arr_delay.length; z < tot; z++) {
     label_data.push(arr_delay[z][0]); //Berisi registrasi, ata, atau ata-subata, dari table delay
     jumlah_delay.push(arr_delay[z][1]); //Berisi jumlah kejadian
  };

  Chart.plugins.register({
    beforeDraw: function(chartInstance) {
      var ctx = chartInstance.chart.ctx;
      ctx.fillStyle = "white";
      ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
    }
  });

  var ctx = document.getElementById("grafik_delay").getContext("2d");

  var data = {
    labels: label_data,
    datasets: [{
      label: "Number of Delay",
      backgroundColor: "lightblue",
      strokeColor: "black",
      data: jumlah_delay
    }]
  };

  var options = {
    title : {
      display : true,
      position : "top",
      text : "Top 10 Delay",
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

  <script>
  /*====================================================================================================
    Chart yang kami buat adalah plugin dari ChartJs
    berikut adalah code untuk memasukkan data hasil querry kedalam chart

    label_data berisi label yang sesuai dengan keinginan user di awal, bisa berupa ata, subata, ata-subata
    sedangkan jumlah_pirep merupakan jumlah kejadian sesuai dengan label
    ====================================================================================================
  */

  var label_data = [];
  var jumlah_pirep = [];
  var z=0;

  var arr_pirep = <?php echo json_encode($arr_pirep); ?>;

  for ( tot=arr_pirep.length; z < tot; z++) {
     label_data.push(arr_pirep[z][0]); //Berisi registrasi, ata, atau ata-subata, dari table pirep
     jumlah_pirep.push(arr_pirep[z][1]); //Berisi jumlah kejadian
  };

  Chart.plugins.register({ //Agar grafik yang dicetak memiliki background putih
    beforeDraw: function(chartInstance) {
      var ctx = chartInstance.chart.ctx;
      ctx.fillStyle = "white";
      ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
    }
  });

  var ctx = document.getElementById("grafik_pirep").getContext("2d");

  var data = {
    labels: label_data,
    datasets: [{
      label: "Number of Pirep",
      backgroundColor: "red",
      strokeColor: "black",
      data: jumlah_pirep
    }]
  };

  var options = {
    title : {
      display : true,
      position : "top",
      text : "Top 10 Pirep",
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

  <script src="js/jspdf.min.js"></script>
  <script src="js/jspdf.plugin.autotable.js"></script>
  <script type="text/javascript">
    // this function generates the pdf using the table
    function generate() {
      var pdfsize = 'a4';
      //console.log(data);
      var canvas = document.querySelector('#grafik_delay');
      var canvas1 = document.querySelector('#grafik_pirep');
      var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
      var canvasImg1 = canvas1.toDataURL("image/jpeg", 2.0);
      var doc = new jsPDF('l', 'pt', pdfsize);
      var width = doc.internal.pageSize.width;

      let finalY = doc.autoTable.previous.finalY;
      doc.addImage(canvasImg, 'JPEG', 40, 40, width-80, 400);
      doc.addPage();
      doc.addImage(canvasImg1, 'JPEG', 40, 40, width-80, 400);
      doc.save("pareto.pdf");
    }
  </script>

</div>
  </body>
</html>
