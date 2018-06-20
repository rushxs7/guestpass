<?php

print_r($_FILES);

if (!empty($_FILES["csvfile"])) {
  $csv = $_FILES["csvfile"];
  $file_name = $csv['name'];
  $file_tmp = $csv['tmp_name'];
  $file_error = $csv['error'];
  $file_ext1 = explode('.', $file_name);
  $file_ext2 = end($file_ext1);
  echo "test";
  if ($file_error === 0) {
      $random = rand(0,999999);
      $file_name_new = "voucher" . $random . "." . $file_ext2;
      $file_destination = "assets/uploads/csv/" . $file_name_new;
      echo "$file_destination";
      move_uploaded_file($file_tmp, $file_destination);
  }else{
    //die("Somehow it failed")
  }
}
?>
