<?php
include("./dataaccess/databaseconnection.php");
// variable id ophalen uit url
$somevar = $_GET["id"];
// query op routeid gebaseert op id uit url
$query = "SELECT * FROM `route` WHERE `routeId` = " . $somevar;
$stm = $con->prepare($query);
if ($stm->execute()) {
    $result = $stm->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $route) {

        echo $route->routeId;
        echo " ";
        echo $route->routeName;
        echo "<br/>";
        $query = "SELECT `courseName` FROM `course` WHERE `courseId` = $route->courseId;";
        $stm = $con->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $course) {
                echo $course->courseName;
            }
        }
        echo "<br/>";
        echo $route->description;
        echo "<img src='data:image/jpeg;base64, " . base64_encode($route->picture) . "' alt='No film found' class='card-image'>";
        echo "<br/>---------------------<br/>";
    }
}
