<?php
  session_start();
  // remove all session variables
  session_unset(); 

  // destroy the session 
  session_destroy();

  header("Location: index.php");
  //echo "All session variables are now removed, and the session is destroyed." 
?>

