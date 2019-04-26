<?php

  //Memilih Ac Type
  $sql0 = "SELECT DISTINCT ACtype FROM tbl_master_actype";
  $res0 = mysqli_query($link, $sql0);

?>

<form action="pareto.php" method="post" class="form-horizontal style-form" style="margin-bottom: 50px">

<br>

<table style="width: 95%; margin: 10px">
  <tbody>
    <tr>
      <td style="width:50%">
        <div class="form-group">
          <label class="control-label">A/C Type</label>
            <div style="padding-left: 50px">
              <label class="checkbox-inline">
                <?php
                  if(isset($_POST['actype'])){
                    for($i=0; $i<10; $i++){
                        $ac_code[$i] = "";
                    }

                    foreach ($_POST['actype'] as $key) {

                      if($key == 'A330') $ac_code[0] = "checked";
                      if($key == 'B737-800E') $ac_code[1] = "checked";
                      if($key == 'B737-800E-M') $ac_code[2] = "checked";
                      if($key == 'B737-800') $ac_code[3] = "checked";
                      if($key == 'B747-400') $ac_code[4] = "checked";
                      if($key == 'B777-300') $ac_code[5] = "checked";
                      if($key == 'ATR72-600') $ac_code[6] = "checked";
                      if($key == 'CRJ-10000') $ac_code[7] = "checked";
                      if($key == 'A320-200') $ac_code[8] = "checked";
                      if($key == 'A320-NEO') $ac_code[9] = "checked";
                    }
                  }
                ?>

                <input type='checkbox' name='actype[]' value='A330' <?php if(isset($_POST['actype'])) echo $ac_code[0]; ?>>A330</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='B737-800E' <?php if(isset($_POST['actype'])) echo $ac_code[1]; ?>>B737-800E</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='B737-800E-M' <?php if(isset($_POST['actype'])) echo $ac_code[2]; ?>>B737-800E-M</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='B737-800' <?php if(isset($_POST['actype'])) echo $ac_code[3]; ?>>B737-800</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='B747-400' <?php if(isset($_POST['actype'])) echo $ac_code[4]; ?>>B747-400</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='B777-300' <?php if(isset($_POST['actype'])) echo $ac_code[5]; ?>>B777-300</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='ATR72-600' <?php if(isset($_POST['actype'])) echo $ac_code[6]; ?>>ATR72-600</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='CRJ-10000' <?php if(isset($_POST['actype'])) echo $ac_code[7]; ?>>CRJ-10000</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='A320-200' <?php if(isset($_POST['actype'])) echo $ac_code[8]; ?>>A320-200</label>
              <label class="checkbox-inline">
                <input type='checkbox' name='actype[]' value='A320-NEO' <?php if(isset($_POST['actype'])) echo $ac_code[9]; ?>>A320-NEO</label>
              <label class="checkbox-inline">
              </label>
            </div>
        </div>
      </td>
      <td style="padding-left:50px; width:50%">
        <div class="form-group">
          <label class="control-label">A/C Registration</label>
            <input type="text" class="form-control" name="acreg" value="<?php if(isset($ACReg))echo $_POST["acreg"] ?>">
        </div>
      </td>
    </tr>

    <tr>
      <td style="width:50%">
        <div class="form-group">
          <label class="control-label">Date from</label>
            <input type="date" class="form-control" name="datefrom" value="<?php if(isset($DateStart))echo $_POST['datefrom'] ?>" required>
        </div>
      </td>
      <td style="padding-left:50px; width:50%">
        <div class="form-group">
          <label class="control-label">Date To</label>
            <input type="date" class="form-control" name="dateto" value="<?php if(isset($DateEnd))echo $_POST['dateto'] ?>" required>
        </div>
      </td>
    </tr>

    <tr>
      <td style="width:50%">
        <div class="form-group">
          <label class="control-label">Graph settings for X-axis</label>
          <div class="radio">
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

          <div class="radio">
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

          <div class="radio">
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
      </td>
    </tr>
    <tr>
      <td>
        <input type="submit" value="Display Report" class="btn btn-default">
      </td>
    </tr>

</tbody>
</table>
</form>
