<?php require('assets/includes/header.php'); ?>
<?php

$connection = mysqli_connect("localhost", "gpadmin", "gpadmin321", "guestpass");
if (!$connection) {
  die("Connection Failed" . mysqli_connect_error());
}
$rollQuery = "select  distinct
              rolls.roll_id,
              rolls.roll_desc,
              rolls.roll_time
              from rolls;";
$rollResult = mysqli_query($connection, $rollQuery);

if (0) {
  $csvfile = $_FILES['csvfile'];
  //file properties
  $file_name = $csvfile['name'];
  $file_tmp = $csvfile['tmp_name'];
  $file_error = $csvfile['error'];
  $file_ext1 = explode('.', $file_name);
  $file_ext2 = end($file_ext1);

  //allowed filetypes
  $file_types = array('csv');
  if ($file_error === 0) {
    $random = rand(0,999999);
    $file_name_new = "voucher" . $random . "." . $file_ext2;
    $file_destination = "assets/uploads/csv/" . $file_name_new;
    move_uploaded_file($file_tmp, $file_destination);
  }else{
    die();
  }
  $voucherFile = fopen($file_destination, 'r');
  $voucherArray = array();
  while (($singleRecord = fgetcsv($voucherFile)) !== FALSE) {
    if ($singleRecord[0][0] != "#") {
      array_push($voucherArray, $singleRecord[0]);
    }
  }
}

?>

<div class="container rounded p-4 mt-5" id="importContainer">
  <h2><center>Import CSV Voucher</center></h2>
  <form action="test.php" method="post">
    <div class="form-group">
      <label for="rollSelect">Roll</label>
      <select class="form-control" id="rollSelect" name="roll_id">
        <?php

        if (mysqli_num_rows($rollResult) > 0) {
          while ($rollRow = mysqli_fetch_assoc($rollResult)) {
            echo '<option value="' . $rollRow['roll_id'] . '">' . $rollRow['roll_desc'] . " (" . $rollRow['roll_time'] . " Minuten)" . "</option>";
          }
        }else {
          echo '<option>Error loading database</option>';
        }

        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="CSVFile">CSV File</label>
      <input class="form-control-file" id="CSVFile" aria-describedby="fileHelp" type="file" name="csvfile" required>
      <small id="fileHelp" class="form-text text-muted">Upload the CSV file here.</small>
    </div>
    <button type="submit" name="importcsv" value="Submit" class="btn btn-outline-primary btn-lg">Import</button>
  </form>
  <?php
    if (isset($voucherArray)) {
      echo "<div>";
        echo '<ul id="voucherList">';
        foreach ($voucherArray as $vouchercode) {
          echo "<li>" . $vouchercode . "</li>";
        }
        echo "</ul>";
      echo "</div>";
    }
  ?>

</div>
<?php mysqli_close($connection); ?>
<?php require('assets/includes/footer.php'); ?>
