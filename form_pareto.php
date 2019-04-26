<?php

/*====================================================================================================
  menampilkan daftar jenis Aircraft sesuai tabel tbl_master_actype
  ====================================================================================================
*/
  $sql0 = "SELECT DISTINCT ACtype FROM tbl_master_actype ORDER BY ACtype ASC";
  $res0 = mysqli_query($link, $sql0);

  /*====================================================================================================
    Agar user tidak lupa akan filter yang telah dipilih, maka kami menampilkan hasil pilihan dan isian
    user ke kolom kolom semula

    Karena halaman ini bersifat dinamis, untuk memastikan apakah user pernah menginputkna sesuatu, maka
    kami beri if(isset) pada setiap filed
    ====================================================================================================
  */
?>

<form action="pareto.php" method="post" class="form-horizontal style-form" style="margin-bottom: 50px">

<br>

<div class="form-group">
<label class="col-xs-6 col-sm-2 control-label">A/C Type</label>
  <div class="col-sm-3">
    <select name="actype" class="form-control">
        <?php
          if(isset($ACType)){
            while($row = $res0->fetch_array(MYSQLI_NUM)){
              if($row[0]==$_POST['actype']){
                $isSelect="selected";
                echo "<option value=".$row[0]." ".$isSelect.">".$row[0]."</option>";
              }
              else{
                echo "<option value=".$row[0].">".$row[0]."</option>";
              }
            }
          }
          else{
            while($row = $res0->fetch_array(MYSQLI_NUM))
              echo "<option value=".$row[0].">".$row[0]."</option>";
          }
         ?>
    </select>
  </div>
  <label class="col-xs-6 col-sm-2 control-label">A/C Reg</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="acreg" value="<?php if(isset($ACReg))echo $_POST["acreg"] ?>">
      <p>Entry Without "PK-"</p>
    </div>
</div>

<div class="form-group">
  <label class="col-xs-6 col-sm-2 control-label">Date from</label>
    <div class="col-sm-3">
      <input type="text" class="form-control datepicker" name="datefrom" id="id_datefrom" value="<?php if(isset($DateStart))echo $_POST['datefrom'] ?>" required>
    </div>
  <label class="col-xs-6 col-sm-2 control-label">Date to</label>
    <div class="col-sm-3">
      <input type="text" class="form-control datepicker" name="dateto" id="id_dateto" value="<?php if(isset($DateEnd))echo $_POST['dateto'] ?>" required>
    </div>
</div>

<div class="form-group">
  <label class="col-sm-2 col-sm-2 control-label">Graph settings for X-axis</label>
  <div class="radio-inline">
      <label>
      <?php
      if(isset($Graph_type)){
        if($Graph_type == 'ata'){
          echo '<input type="radio" name="graph" id="radio_graph" value="ata" checked required>';
        }
        else {
          echo '<input type="radio" name="graph" id="radio_graph" value="ata" required>';
        }
      }
      else {
        echo '<input type="radio" name="graph" id="radio_graph" value="ata" required>';
      }
      ?>
               ATA
      </label>
  </div>

  <div class="radio-inline">
      <label>
        <?php
        if(isset($Graph_type)){
          if($Graph_type == 'ac_reg'){
            echo '<input type="radio" name="graph" id="radio_graph" value="ac_reg" checked required>';
          }
          else {
            echo '<input type="radio" name="graph" id="radio_graph" value="ac_reg" required>';
          }
        }
        else {
            echo '<input type="radio" name="graph" id="radio_graph" value="ac_reg" required>';
        }
        ?>
               A/C REG
      </label>
  </div>

  <div class="radio-inline">
      <label>
        <?php
        if(isset($Graph_type)){
          if($Graph_type == 'sub_ata'){
            echo '<input type="radio" name="graph" id="radio_graph" value="sub_ata" checked required>';
          }
          else {
            echo '<input type="radio" name="graph" id="radio_graph" value="sub_ata" required>';
          }
        }
        else {
            echo '<input type="radio" name="graph" id="radio_graph" value="sub_ata" required>';
        }
        ?>
                 Sub ATA
      </label>
  </div>
</div>

<input type="submit" value="Display Report" class="btn btn-default">
</form>

<script>
$( function() {
  $( ".datepicker" ).datepicker({
      dateFormat: "dd/mm/yy",
      changeYear: true,
      changeMonth: true
  });
});
</script>
