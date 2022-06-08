<?php
session_start();
if(!$_SESSION['isLoggedIn']){
  header("Location: login.php?error=Er is niet ingelogd");
  exit();
}
?>