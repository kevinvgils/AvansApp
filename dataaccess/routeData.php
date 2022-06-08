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

function getAllRoutes()
{
    include("databaseconnection.php");
    $allRoutesQuery = "SELECT * FROM `route`";
    $stm = $con->prepare($allRoutesQuery);
    if ($stm->execute()) {
        $allRoutes = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allRoutes;
}

function addQuestionToRoute($routeId, $question, $description, $latitude, $longitude, $image, $videoUrl)
{
    include("databaseconnection.php");
    $query = "INSERT INTO `question`(`routeId`, `question`, `description`, `latitude`, `longitude`, `image`, `videoUrl`) VALUES (:routeId, :question, :descr, :latitude, :longitude, :img, :videoUrl)";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $routeId);
    $stm->bindValue(':question', $question);
    $stm->bindValue(':descr', $description);
    $stm->bindValue(':latitude', (empty($latitude)) ? null : $latitude);
    $stm->bindValue(':longitude', (empty($longitude)) ? null : $longitude);
    $stm->bindValue(':img', (empty($image)) ? null : $image);
    $stm->bindValue(':videoUrl', (empty($videoUrl)) ? null : $videoUrl);

    $stm->execute();
}