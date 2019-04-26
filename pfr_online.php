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

    <title>Aircraft Reliability - PFR Online</title>

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

  </head>

  <body>

    <section id="container" >

      <?php
        include 'header.php';
       ?>

      <?php
        $page_now = "pfr";
        include 'navbar.php';
       ?>

      <section id="main-content" style="min-height:94vh">
        <section class="wrapper" style="text-align: centered; top: 50%; left: 50%;">
                <!-- <script type="application/javascript">

                  function resizeIFrameToFitContent( iFrame ) {

                      iFrame.width  = iFrame.contentWindow.document.body.scrollWidth;
                      iFrame.height = iFrame.contentWindow.document.body.scrollHeight;
                  }

                  window.addEventListener('DOMContentLoaded', function(e) {

                      var iFrame = document.getElementById( 'iFrame1' );
                      resizeIFrameToFitContent( iFrame );

                      // or, to resize all iframes:
                      var iframes = document.querySelectorAll("iframe");
                      for( var i = 0; i < iframes.length; i++) {
                          resizeIFrameToFitContent( iframes[i] );
                      }
                  } );

                </script> -->

                <iframe src="http://192.168.40.101/reliability/PFR_new/bin/CRJ.html" id="iFrame1" height="600" width="1000"></iframe>
        </section>
      </section>

    <?php
    include 'footer.php';
    ?>

    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
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
  </body>
</html>
