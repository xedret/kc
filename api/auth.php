<?php
 require_once( "../lib/db.php" );

 function jEcho( $obj ) { echo( json_encode( $obj, JSON_PRETTY_PRINT ) ); }
 function jDie( $obj ) { die( json_encode( $obj, JSON_PRETTY_PRINT ) ); }
 function getRandomHex( $num_bytes=9 ) { return bin2hex( openssl_random_pseudo_bytes( $num_bytes ) ); }

 $rm = $_SERVER[ 'REQUEST_METHOD' ];
 if ( $rm !== "POST" && $rm !== "DELETE" ) {
  header( 'HTTP/1.1 405 Method Not Allowed' );
  jDie( [ "error" => "Method Not Allowed, this API processes only POST and DELETE requests."  ] );
 }

 $_POST = json_decode( file_get_contents( 'php://input' ), true );

 $db = connectDB();

 if( $rm === "POST" ) { // Log In
  $query1 = 'SELECT uid, user, password, active FROM api_users WHERE user=?;';
  if( !( $stmt1 = $db -> prepare( $query1 ) ) ) {
   jDie( [ "success" => false, "error" => $db -> errno . " " . $db -> error ] );
  }
  $stmt1 -> bind_param( "s", $_POST[ 'user' ] );
  $stmt1 -> execute();
  if( $db -> errno ) { jDie( [ "success" => false, "error" => $stmt1 -> error ] ); }
  $res1 = $stmt1 -> get_result();
  // 'd8570a8ca9a3407abf3b6b6772f3d89c', 'robot', '5f4dcc3b5aa765d61d8327deb882cf99', 1 (Password)
  if( $res1 -> num_rows === 0 ) { jEcho( [ "success" => false, "error" => "user" ] ); }
  else {
   $row1 = $res1 -> fetch_assoc();
   if( $row1[ 'active' ] == 1 ) {
    if( $row1[ 'password' ] == md5( $_POST[ 'pass' ] ) ) {
     $token = getRandomHex();
     $query2 = "
      INSERT INTO `auth` ( `uid`, `token`, `expiry` ) VALUES ( ?, ?, DATE_ADD( CURRENT_TIMESTAMP(), INTERVAL 1 DAY) )
      ON DUPLICATE KEY UPDATE token = VALUES( token ), expiry = VALUES( expiry );
     ";
     if( !( $stmt2 = $db -> prepare( $query2 ) ) ) {
      jDie( [ "success" => false, "error" => $db -> errno . " " . $db -> error ] );
     }
     $stmt2 -> bind_param( "ss", $row1[ 'uid' ], $token );
     $stmt2 -> execute();
     $db -> close();
     jEcho( [ 'success' => true, 'token' => $token, 'uid' => $row1[ 'uid' ] ] );
    }
    elseif( $row[ 'password' ] != md5( $_POST[ 'pass' ] ) ) { jEcho( [ "success" => false, "error" => "pass" ] ); }
   }
   elseif( $row[ 'active' ] == 0 ) { jEcho( [ "success" => false, "error" => "dead" ] ); }
  }
 }
 elseif( $rm === "DELETE" ) { // Log Out
  $query1 = "SELECT token FROM `auth` WHERE token=?;";
  if( !( $stmt1 = $db -> prepare( $query1 ) ) ) {
   jDie( [ "success" => false, "error" => $db -> errno . " " . $db -> error ] );
  }
  $stmt1 -> bind_param( "s", $_POST[ 'token' ] );
  $stmt1 -> execute();
  if( $db -> errno ) { jDie( "Query Error: " . $stmt1 -> errno ); }
  $res = $stmt1 -> get_result();
  if( $res -> num_rows === 0 ) {
   jEcho( [ "success" => true, "error" => "token" ] ); // Token doesn't exist, log out anyways.
  }
  elseif( $res -> num_rows === 1 ) {
   $query2 = "DELETE FROM auth WHERE token=?;";
   if( !( $stmt2 = $db -> prepare( $query2 ) ) ) {
    jDie( [ "success" => false, "error" => $db -> errno . " " . $db -> error ] );
   }
   $stmt2 -> bind_param( "s", $_POST[ 'token' ] );
   $stmt2 -> execute();
   jEcho( [ "success" => true ] ); // Token deleted at this point.
  }
 }

?>
