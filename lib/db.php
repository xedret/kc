<?php
 // DB connection data
 $host = "localhost";
 $user = "root";
 $pass = "password";

 function connectDB( $database = "kc" ) {
  global $host;
  global $user;
  global $pass;
  $db = new mysqli( $host, $user, $pass, $database );
  if( $db -> connect_errno ) { jDie( [ "success" => false, "error" => $db -> connect_error ] ); }
  mysqli_set_charset( $db, "utf8" );
  return $db;
 }
?>
