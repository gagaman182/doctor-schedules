<?php
header('Access-Control-Allow-Origin: *');

include 'conn.php';



// $sql = "SELECT doc_code,concat(doc_code,'-',name) as name  from doctor
$sql = "SELECT *  from doctor
     
      ";


$return_arr = array();

if ($result = mysqli_query($conn, $sql)) {
  while ($row = mysqli_fetch_assoc($result)) {

    array_push($return_arr, $row);
  }
}

mysqli_close($conn);

echo json_encode($return_arr);