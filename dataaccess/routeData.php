<?php
    function getAllRoutes() {
        include("databaseconnection.php");

        $allRoutesQuery = "SELECT * FROM `route`";
        $stm = $con->prepare($allRoutesQuery);
        if ($stm->execute()) {
            $allRoutes = $stm->fetchAll(PDO::FETCH_OBJ);
        }
        return $allRoutes;
    }
?>