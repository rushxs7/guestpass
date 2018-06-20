<?php
  $voucherFile = fopen('vouchers.csv', 'r');
  $voucherArray = array();
  while (($singleRecord = fgetcsv($voucherFile)) !== FALSE) {
    if ($singleRecord[0][0] != "#") {
      array_push($voucherArray, $singleRecord[0]);
    }
  }
  foreach ($voucherArray as $value) {
    // echo "Vouchercode: " . $value . "<br>";
  }

  print_r($voucherArray);
?>
