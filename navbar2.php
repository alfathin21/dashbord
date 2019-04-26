<!--sidebar start -->

<aside>
    <div id="sidebar"  class="nav-collapse " style="z-index:1; top: 0px;">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><img src="assets/img/logo_gmf.jpg" class="img-circle" width="150"></p>
            <h5 class="centered">GMF Aeroasia</h5>

            <li class="mt">
              <?php
                if($page_now == "graph"){
                  echo "<a class='active' href='awal_graph.php'>";
                }
                else {
                  echo "<a href='awal_graph.php'>";
                }
              ?>
                    <i class="fa fa-dashboard"></i>
                    <span>Graph Display</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php
                if($page_now == "pareto"){
                  echo "<a class='active' href='awal_pareto.php'>";
                }
                else {
                  echo "<a href='awal_pareto.php'>";
                }
              ?>
                    <i class="fa fa-desktop"></i>
                    <span>Pareto Display</span>
                </a>
                <!--
                <ul class="sub">
                    <li><a  href="general.html">General</a></li>
                    <li><a  href="buttons.html">Buttons</a></li>
                    <li><a  href="panels.html">Panels</a></li>
                </ul>
              -->
            </li>

            <li class="sub-menu">
              <?php
                if($page_now == "component"){
                  echo "<a class='active' href='awal_component.php'>";
                }
                else {
                  echo "<a href='awal_component.php'>";
                }
              ?>
                    <i class="fa fa-cogs"></i>
                    <span>Components Display</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php
                if($page_now == "mtbur"){
                  echo "<a class='active' href='awal_mtbur.php'>";
                }
                else {
                  echo "<a href='awal_mtbur.php'>";
                }
              ?>
                    <i class="fa fa-database"></i>
                    <span>MTBUR</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php
                if($page_now == "oil"){
                  echo "<a class='active' href='oil_consumption.php'>";
                }
                else {
                  echo "<a href='oil_consumption.php'>";
                }
              ?>
                    <i class="fa fa-fire"></i>
                    <span>Oil Consumption</span>
                </a>
            </li>

            <!--
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-book"></i>
                    <span>Extra Pages</span>
                </a>
                <ul class="sub">
                    <li><a  href="blank.html">Blank Page</a></li>
                    <li><a  href="login.html">Login</a></li>
                    <li><a  href="lock_screen.html">Lock Screen</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-tasks"></i>
                    <span>Forms</span>
                </a>
                <ul class="sub">
                    <li><a  href="form_component.html">Form Components</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-th"></i>
                    <span>Data Tables</span>
                </a>
                <ul class="sub">
                    <li><a  href="basic_table.html">Basic Table</a></li>
                    <li><a  href="responsive_table.html">Responsive Table</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class=" fa fa-bar-chart-o"></i>
                    <span>Charts</span>
                </a>
                <ul class="sub">
                    <li><a  href="morris.html">Morris</a></li>
                    <li><a  href="chartjs.html">Chartjs</a></li>
                </ul>
            </li>
          -->

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
