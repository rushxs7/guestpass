<?php
  $connection = mysqli_connect("localhost", "gpadmin", "gpadmin321", "guestpass");
  if (!$connection) {
    die("Connection Failed" . mysqli_connect_error());
  }
  $printVoucherQuery = 'select
                          vouchers.voucher_code as vcode,
                          rolls.roll_desc as descr
                        from
                          vouchers, rolls
                        where
                          vouchers.roll_id = rolls.roll_id
                        and
                          vouchers.voucher_id =' . $_GET['vid'] . ';';
  $printVoucherResult = mysqli_query($connection, $printVoucherQuery);
  if (mysqli_num_rows($printVoucherResult) > 0) {
    $printVoucherArray = mysqli_fetch_assoc($printVoucherResult);
  }else{
    die("No such voucher.");
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Print Voucher</title>
    <style>
      body {
        width: 200px;
        border: 1px dashed black;
        padding: 1.5em 0.1em;
      }
      .receiptContainer{
        text-align: center;
      }
      #voucherTitle {
        font-size: 150%;
        font-weight: 600;
      }
      #voucherSubtext {
        font-size: 80%;
        color: grey;
      }
      #voucherCodeText {
        margin-top: 3em;
        font-size: 90%;
      }
      #voucherCode {
        margin: 0.6em;
        border: 2px solid black;
        padding: 0.3em;
        font-size: 100%;
      }
      #voucherMessage {
        font-size: 65%;
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <div class="receiptContainer">
      <div id="voucherTitle">ACMA N.V.</div>
      <div id="voucherSubtext">gast internet toegang</div>
      <div id="voucherCodeText">Vouchercode:</div>
      <div id="voucherCode"><?php echo $printVoucherArray['vcode']; ?></div>
      <div id="voucherMessage">goed voor <?php echo strtolower($printVoucherArray['descr']); ?> internet toegang</div>
    </div>
  </body>
  <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script>
    $(document).ready(function() {
      window.print();
    });
  </script>
</html>

<?php mysqli_close($connection); ?>
