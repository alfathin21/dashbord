<?php

  //Memilih Ac Type
  $sql0 = "SELECT DISTINCT ACtype FROM tbl_master_actype";
  $res0 = mysqli_query($link, $sql0);

?>

<form action="component_removal.php" method="post" class="form-horizontal style-form" style="margin-bottom: 50px">

<br>

  <div class="form-group">
  <label class="col-sm-2 col-sm-2 control-label">A/C Type</label>
    <div class="col-sm-10">
      <select name="actype" class="form-control">
        <?php
          if(isset($ACType)){
            while($row = $res0->fetch_array(MYSQLI_NUM)){
              if($_POST["actype"] == $row[0]){
                  echo "<option value=".$row[0]." selected>".$row[0]."</option>";
              }
              else {
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
  </div>

  <div class="form-group">
    <label class="col-sm-2 col-sm-2 control-label">A/C Registration</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="acreg" value="<?php if(isset($ACReg))echo $_POST["acreg"] ?>">
      </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 col-sm-2 control-label">Part Number</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="part_no" value="<?php if(isset($PartNum))echo $_POST["part_no"] ?>">
      </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 col-sm-2 control-label">Date from</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" name="datefrom" value="<?php if(isset($DateStart))echo $_POST["datefrom"] ?>" required>
      </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 col-sm-2 control-label">Date to</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" name="dateto" value="<?php if(isset($DateEnd))echo $_POST['dateto'] ?>" required>
      </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 col-sm-2 control-label">Removal Code</label>
      <div class="col-sm-10">
        <label class="checkbox-inline">
          <?php
            if(isset($RemCode)){
              $sign = false;
              $unsign = false;
              foreach ($RemCode as $key) {
                if($key == "u") $unsign = true;
                if($key == "s") $sign = true;
              }
              if($unsign){
                echo "<input type='checkbox' name='remcode[]' value='u' checked>";
              }
              else {
                echo "<input type='checkbox' name='remcode[]' value='u'>";
              }
            }
            else {
              echo "<input type='checkbox' name='remcode[]' value='u'>";
            }
           ?>
					 Unscheduled
				</label>
				<label class="checkbox-inline">
          <?php
          if(isset($RemCode)){
              if($sign){
                  echo "<input type='checkbox' name='remcode[]' value='s' checked>";
              }
              else {
                echo "<input type='checkbox' name='remcode[]' value='s'>";
              }

            }
          else {
            echo "<input type='checkbox' name='remcode[]' value='s'>";
          }
           ?>
					Scheduled
				</label>
      </div>
  </div>

  <input type="submit" value="Display Report" class="btn btn-default">

</form>
