<?php
    $oid = $_GET['O_id'];
    $rconsent = $_GET['R_Consent'];
    $rname = $_GET['R_Name'];
    $raddress = $_GET['R_Address'];
    $rcnic = $_GET['R_CNIC'];
    $rcontact = $_GET['R_Contact'];
    $pid = $_GET['P_id'];
    

/* Logic of DB */
if (empty($rconsent)) {
  $rconsent = NULL;
}
if (empty($rname)) {
  $rname = NULL;
}
if (empty($raddress)) {
  $raddress = NULL;
}
if (empty($rcnic)) {
  $rcnic = NULL;
}
if (empty($rcontact)) {
  $rcontact = NULL;
}
if (empty($oid) or empty($pid) ) {
  echo "Warning! Must enter Primary Key(oid) And Foreign Key(pid).";
} else {

  $conn = mysqli_connect('localhost', 'root', '', 'carecenter');
  $sql = "SELECT max(P_id) AS max FROM `patient` ";
  $result = mysqli_query($conn , $sql);
  $row = mysqli_fetch_array($result);
  $largest = $row['max'];

  if (!$conn) {
    die("Connection Failed. ");
  } 
  else {
    $queryCheck = "SELECT * FROM `operation` WHERE O_id = $oid ";
    $myResultCheck = mysqli_query($conn, $queryCheck);
    if (mysqli_num_rows($myResultCheck) > 0) {
      echo '<q>' . 'Record Already Exist' . '</q>';
    } 
    else {
      if( $pid <= $largest ){
        $query = "INSERT INTO `operation` (`O_id`, `R_Consent`, `R_Name`, `R_Address`, `R_CNIC`, `R_Contact`, `P_id`) VALUES ('$oid', '$rconsent', '$rname', '$raddress', '$rcnic', '$rcontact', '$pid')";
        if (mysqli_query($conn, $query)) {
          echo '<q>' . "Record Insertion Succeed" . '</q>';
        } 
        else {
          echo "Error" . $query . "<br>" . mysqli_error($conn);
        }
      }
      else{
        echo "Sorry! p_id max limit is from 0 to ". $largest ;
      }
    }
  }
  mysqli_close($conn);
}
?>