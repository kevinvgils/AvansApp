<?php
function getCourses()
{
    include("databaseconnection.php");
    $query2 = "SELECT * FROM `course`";
    $stm = $con->prepare($query2);
    if ($stm->execute()) {
        $result2 = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result2;
}
