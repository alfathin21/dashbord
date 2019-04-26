<!--sidebar start -->

<aside>
    <div id="sidebar"  class="nav-collapse " style="z-index:1; top: 0px;">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <li class="mt">
              <?php //Urutan 1
                if($page_now == "graph"){
                  echo "<a class='active' href='awal_graph.php'>";
                }
                else {
                  echo "<a href='awal_graph.php'>";
                }
              ?>
                    <i class="fa fa-dashboard"></i>
                    <span>Techlog / Delay</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php //Urutan 2
                if($page_now == "pareto"){
                  echo "<a class='active' href='awal_pareto.php'>";
                }
                else {
                  echo "<a href='awal_pareto.php'>";
                }
              ?>
                    <i class="fa fa-desktop"></i>
                    <span>Pareto Techlog / Delay</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php //Urutan 3
                if($page_now == "component"){
                  echo "<a class='active' href='awal_component.php'>";
                }
                else {
                  echo "<a href='awal_component.php'>";
                }
              ?>
                    <i class="fa fa-cogs"></i>
                    <span>Components Removal</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php //Urutan 4
                if($page_now == "pareto_comp"){
                  echo "<a class='active' href='awal_pareto_comp.php'>";
                }
                else {
                  echo "<a href='awal_pareto_comp.php'>";
                }
              ?>
                    <i class="fa fa-desktop"></i>
                    <span>Pareto Component Removal</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php //Urutan 5
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
              <?php // Uurtan 6
                if($page_now == "mtbur_w"){
                  echo "<a class='active' href='mtburw.php'>";
                }
                else {
                  echo "<a href='mtburw.php'>";
                }
              ?>
                    <i class="fa fa-folder"></i>
                    <span>MTBUR WW</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php // Urutan 7
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

            <li class="sub-menu">
              <?php // Urutan 8
                if($page_now == "pfr"){
                  echo "<a class='active' href='pfr_online.php'>";
                }
                else {
                  echo "<a href='pfr_online.php'>";
                }
              ?>
                    <i class="fa fa-paper-plane"></i>
                    <span>Pfr Online</span>
                </a>
            </li>

            <li class="sub-menu">
              <?php //Urutan 9
                if($page_now == "help"){
                  echo "<a class='active' href='help.php'>";
                }
                else {
                  echo "<a href='help.php'>";
                }
              ?>
                    <i class="fa fa-question-circle"></i>
                    <span>User Guide</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
