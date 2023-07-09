<?php 
  session_start();
  include 'php/db.php';
  $unique_id = $_SESSION['unique_id'];
   $qry= mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
  if(mysqli_num_rows($qry) > 0){
    $row = mysqli_fetch_assoc($qry);
    header ("Location: index.php");
  }
?>
