<?php


function addRoutes($routeName, $course, $desc, $picture)
{
    include("databaseconnection.php");
    $query = "INSERT INTO `route`(`routeName`, `description`, `courseId`, `picture`) VALUES (:routeName,:description,:course,'$picture')";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeName', $routeName);
    $stm->bindValue(':course', $course);
    $stm->bindValue(':description', $desc);

    $stm->execute();
}

function getAllActiveRoutes()
{
    include("databaseconnection.php");
    $allRoutesQuery = "SELECT * FROM `route` WHERE `isActive` = 1";
    $stm = $con->prepare($allRoutesQuery);
    if ($stm->execute()) {
        $allRoutes = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allRoutes;
}

function getAllRoutesByCourse($courseId)
{
    include("databaseconnection.php");
    $allRoutesQuery = "SELECT * FROM `route` WHERE `courseId` = :courseId AND `isActive` = 1;";
    $stm = $con->prepare($allRoutesQuery);
    $stm->bindValue(':courseId', $courseId);

    if ($stm->execute()) {
        $allRoutes = $stm->fetchAll(PDO::FETCH_OBJ);
    }

    return $allRoutes;
}

function archiveRoute($routeId)
{
    include("databaseconnection.php");
    $allRoutesQuery = "UPDATE `route` SET `isActive` = '0' WHERE `route`.`routeId` = :routeId;";
    $stm = $con->prepare($allRoutesQuery);
    $stm->bindValue(':routeId', $routeId);
    if ($stm->execute()) {
        $allRoutes = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allRoutes;
}
