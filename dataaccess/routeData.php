<?php
        $allRoutesQuery = "SELECT * FROM `route`";
        $stm = $con->prepare($allRoutesQuery);
        $allRoutes;
        if ($stm->execute()) {
            $allRoutes = $stm->fetchAll(PDO::FETCH_OBJ);
        }
?>