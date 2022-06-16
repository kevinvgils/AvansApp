<?php
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");

archiveRoute($_GET['routeId']);

header("Location: ../admin/index.php");
exit();
