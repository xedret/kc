<?php
 require_once( "../lib/db.php" );

 function jEcho( $obj ) { echo( json_encode( $obj, JSON_PRETTY_PRINT ) ); }
 function jDie( $obj ) { die( json_encode( $obj, JSON_PRETTY_PRINT ) ); }
 function getRandomHex( $num_bytes=9 ) { return bin2hex( openssl_random_pseudo_bytes( $num_bytes ) ); }

 $rm = $_SERVER[ 'REQUEST_METHOD' ];
 if ( $rm !== "GET" ) {
  header( 'HTTP/1.1 405 Method Not Allowed' );
  jDie( [ "error" => "Method Not Allowed, this API can only process GET requests."  ] );
 }

 $h = getallheaders();
 if( !isset( $h[ 'token' ] ) ) { // Token not provided
  header( 'HTTP/1.1 401 Unauthorized' );
  jDie( [ 'success' => false, 'error' => 'token' ] );
 }
 else { // Token provided, lets challenge it.
  $db = connectDB();
  $query1 = 'SELECT * FROM auth WHERE token=?;';
  if( !( $stmt1 = $db -> prepare( $query1 ) ) ) {
   jDie( [ "success" => false, "error" => $db -> errno . " " . $db -> error ] );
  }
  $stmt1 -> bind_param( "s", $h[ 'token' ] );
  $stmt1 -> execute();
  if( $db -> errno ) { jDie( [ "success" => false, "error" => $stmt1 -> error ] ); }
  $res1 = $stmt1 -> get_result();
  if( $res1 -> num_rows === 0 ) {
   header( 'HTTP/1.1 403 Forbidden' ); // If provided token is invalid
   jDie( [ "success" => false, "error" => "expired" ] );
  }
  $query2 = "SELECT `name`, `lname`, `email`, `active` FROM students";
  if( !( $stmt2 = $db -> prepare( $query2 ) ) ) {
   jDie( [ "success" => false, "error" => $db -> errno . " " . $db -> error ] );
  }
  $stmt2 -> execute();
  $res2 = $stmt2 -> get_result();
  $students = [];
  while ( $row2 = $res2 -> fetch_assoc() ) { array_push( $students, $row2 ); }
  jEcho( [ 'success' => true, 'students' => $students ] );
 }
?>
