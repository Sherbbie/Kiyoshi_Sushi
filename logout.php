
<?php
  include("./header_footer/header.php");
  if(isset($_SESSION["LoginUserSession"]) == 1)
  {

  unset($_SESSION);

  session_destroy();

  session_start();


  }
  header("Location: home.php");
?>
