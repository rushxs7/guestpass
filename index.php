<?php require 'assets/includes/header.php' ?>

<div class="container p-4">
  <center>
    <div class="rounded bg-dark text-light px-4 py-4" id="voucherPanel">
      <center>
        <h1>GuestPass</h1>
        <form action="test.php" method="post">
          <div class="form-group">
            <label for="voucherSelect">Tijd per Voucher</label>
            <select class="form-control" id="voucherSelect" name="minutes">
              <option value="120">2 Uren</option>
              <option value="480">8 Uren</option>
              <option value="4320">3 Dagen</option>
              <option value="10080">7 Dagen</option>
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

<?php require 'assets/includes/footer.php' ?>
