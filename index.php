<?php require 'assets/includes/header.php' ?>

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


?>

<div class="container p-4">
  <center>
    <div class="rounded bg-dark text-light px-4 py-4" id="voucherPanel">
      <center>
        <h1>GuestPass</h1>
        <form action="index.php" method="post" autocomplete="off">
          <div class="form-group">
            <label for="voucherSelect">Tijd per Voucher</label>
            <select class="form-control" id="voucherSelect" name="minutes">
              <?php

              if (mysqli_num_rows($rollResult) > 0) {
                while ($rollRow = mysqli_fetch_assoc($rollResult)) {
                  echo '<option value="' . $rollRow['roll_time'] . '">' . $rollRow['roll_desc'] . "</option>";
                }
              }else {
                echo '<option>Error loading database</option>';
              }

              ?>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info btn-lg">Voucher Aanvragen</button>
          </div>
          <div class="form-group" id="voucherCodeFieldSet">
            <fieldset>
              <label class="control-label" for="voucherReadOnly">Vouchercode:</label>
              <input class="form-control" id="voucherReadOnly" placeholder="xxxxxxxxxxxxx" readonly="" type="text" value="">
              <button type="button" name="printButton" class="btn mt-2 btn-primary" id="printButton">&#128438; Print Voucher</button>
            </fieldset>
          </div>
        </form>
      </center>
    </div>
  </center>
</div>

<?php

  mysqli_close($connection);

?>

<?php require 'assets/includes/footer.php' ?>
