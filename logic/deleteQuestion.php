<?php 
include("../dataaccess/databaseconnection.php");
include("../dataaccess/questionData.php");

if(deleteQuestion($_GET['id'])){
  echo "question deleted";
} else {
  echo "question not deleted";
}
header("Location: ../admin/detailpage.php?id=".$_GET['routeId']);
exit();
?>