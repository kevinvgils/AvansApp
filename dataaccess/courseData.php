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

function getCourseById($id)
{
    include("databaseconnection.php");
    $query2 = "SELECT * FROM `course` WHERE `courseId` = :id";
    $stm = $con->prepare($query2);
    $stm->bindValue(':id', $id);
    if ($stm->execute()) {
        $result2 = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result2;
}