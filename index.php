<?php require 'assets/includes/header.php'; ?>

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

  if (isset($_POST['minutes'])) {
    $voucherQuery = "select
                        vouchers.voucher_id as vid,
                        rolls.roll_desc as descr,
                        vouchers.voucher_code as code
                      from
                        rolls, vouchers
                      where
                        (rolls.roll_id = vouchers.roll_id)
                      and
                        (roll_time = " . $_POST['minutes'] . ")
                      and
                          voucher_used = 0
                      limit 1;";
    $voucherQueryResult = mysqli_query($connection, $voucherQuery);
    $voucherArray = array();
    if (mysqli_num_rows($voucherQueryResult) > 0) {
      $voucherArray = mysqli_fetch_assoc($voucherQueryResult);
    }
    $updateVoucher = "update vouchers set voucher_used=1 where voucher_id=" . $voucherArray['vid'] . ";";
    if (mysqli_query($connection, $updateVoucher)) {
      $updateError = 0;
      $updateMessage = "Voucher succesvol geregistreerd.";
    }else{
      $updateError = 1;
      $updateMessage = "Geen vouchers over.";
    }
  }

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
                echo '<option>Error bij het laden van de database</option>';
              }

              ?>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info btn-lg">Voucher Aanvragen</button>
          </div>
          <?php
            if (isset($_POST['minutes']) && $updateError != 1) {
              echo '<div class="form-group" id="voucherCodeFieldSet">
                      <fieldset>
                        <label class="control-label" for="voucherReadOnly">Vouchercode:</label>
                        <input class="form-control" id="voucherReadOnly" placeholder="xxxxxxxxxxxxx" readonly="" type="text" value="' . $voucherArray['code'] . '">
                        <a class="btn mt-2 btn-primary" id="printButton" href="printv.php?vid=' . $voucherArray['vid'] .  '" target="_blank">&#128438; Print Voucher</a>
                      </fieldset>
                      <div id="errorMessage" class="mt-2">' . $updateMessage . '</div>
                    </div>';
            }else{
              echo '<div class="form-group" id="errorMessage">' . $updateMessage . '</div>';
            }
          ?>
        </form>
      </center>
    </div>
  </center>
</div>

<?php mysqli_close($connection); ?>

<?php require 'assets/includes/footer.php'; ?>
