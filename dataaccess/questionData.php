<?php
function getAllQuestionsForRoute($routeId)
{
    include("databaseconnection.php");
    $intRouteId = (int)$routeId;
    $allQuestionsQuery = "SELECT * FROM `question` WHERE `routeId` = :routeId";
    $stm = $con->prepare($allQuestionsQuery);
    $stm->bindValue(':routeId', $intRouteId);
    if ($stm->execute()) {
        $allQuestions = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allQuestions;
}

function addQuestionToRoute($routeId, $questionType, $question, $description, $latitude, $longitude, $image, $videoUrl, $allAnswers)
{
    include("databaseconnection.php");
    $query = "INSERT INTO `question`(`questionType`, `routeId`, `question`, `description`, `latitude`, `longitude`, `image`, `videoUrl`) VALUES (:questionType, :routeId, :question, :descr, :latitude, :longitude, '$image', :videoUrl)";
    $stm = $con->prepare($query);
    $stm->bindValue(':questionType', $questionType);
    $stm->bindValue(':routeId', $routeId);
    $stm->bindValue(':question', $question);
    $stm->bindValue(':descr', $description);
    $stm->bindValue(':latitude', (empty($latitude)) ? null : $latitude);
    $stm->bindValue(':longitude', (empty($longitude)) ? null : $longitude);
    $stm->bindValue(':videoUrl', (empty($videoUrl)) ? null : $videoUrl);

    $stm->execute();

    if($questionType == 0){
        $questionId = $con->lastInsertId();
        addAnswersToQuestion($questionId, $allAnswers);
    }
}

function updateQuestionToRoute($questionId, $routeId, $questionType, $question, $description, $latitude, $longitude, $image, $videoUrl, $allAnswers){
    $imageString = "";
    if($image != null){
        $imageString = "`image`= '$image',";
    }
    include("databaseconnection.php");
    $query = "UPDATE `question`".
     " SET `questionType`=:questionType, `question`=:question, `description`=:descr, `latitude`=:latitude, `longitude`=:longitude, $imageString `videoUrl`=:videoUrl".
     " WHERE `questionId`=:questionId;";
    $stm = $con->prepare($query);
    $stm->bindValue(':questionType', $questionType);
    $stm->bindValue(':question', $question);
    $stm->bindValue(':descr', $description);
    $stm->bindValue(':latitude', (empty($latitude)) ? null : $latitude);
    $stm->bindValue(':longitude', (empty($longitude)) ? null : $longitude);
    $stm->bindValue(':videoUrl', (empty($videoUrl)) ? null : $videoUrl);
    $stm->bindValue(':questionId', $questionId, PDO::PARAM_INT);
    $stm->execute();

    deleteAllAnswersToQuestion($questionId);

    if($questionType == 0){
        addAnswersToQuestion($questionId, $allAnswers);
    }
}

function deleteAllAnswersToQuestion($questionId){
    include("databaseconnection.php");
    $query = "DELETE FROM `answer` WHERE `questionId` = :questionId";
    $stm = $con->prepare($query);
    $stm->bindValue(':questionId', $questionId, PDO::PARAM_INT);
    $stm->execute();
}

function addAnswersToQuestion($questionId, $allAnswers)
{
    include("databaseconnection.php");
    foreach ($allAnswers as $answer) {
        if (!empty($answer[1])) {
            $query = "INSERT INTO `answer`(`questionId`, `answer`, `isCorrect`) VALUES (:questionId, :answer, :isCorrect)";
            $stm = $con->prepare($query);
            $stm->bindValue(':questionId', $questionId);
            $stm->bindValue(':answer', $answer[1]);
            $stm->bindValue(':isCorrect', $answer[2]);

            $stm->execute();
        } else {
            break;
        }
    }
}

function getAllAnswersForQuestion($questionId)
{
    include("databaseconnection.php");
    $intQuestionId = (int)$questionId;
    $allAnswersQuery = "SELECT * FROM `answer` WHERE `questionId` = :questionId";
    $stm = $con->prepare($allAnswersQuery);
    $stm->bindValue(':questionId', $questionId);
    if ($stm->execute()) {
        $allAnswers = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allAnswers;
}

function getRouteName($sessionRouteId)
{
    include("databaseconnection.php");


    $query = "SELECT * FROM `route` WHERE `routeId` = :routeId";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $sessionRouteId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }

    return $result;
}
function getGlobalQuestion($sessionRouteId)
{
    include("databaseconnection.php");
    $query = "SELECT * FROM `question` WHERE `longitude` IS NULL AND `routeId` = :routeId";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $sessionRouteId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}
function getLocalQuestion($sessionRouteId)
{
    include("databaseconnection.php");

    $query = "SELECT * FROM `question` WHERE `longitude` IS NOT NULL AND `routeId` = :routeId";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $sessionRouteId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }

    return $result;
}

function getLocationCheck($getRouteId)
{
    include("databaseconnection.php");
    $query = "SELECT * FROM `question` WHERE `longitude` IS NOT NULL AND `latitude` IS NOT NULL AND `routeId` = :routeId";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $getRouteId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}
function getQuestionDetails($getQuestionId, $sessionRouteId)
{
    include("databaseconnection.php");
    $query = "SELECT * FROM `question` WHERE `questionId` = :questionId AND `routeId` = :routeId";
    $stm = $con->prepare($query);
    $stm->bindValue(':questionId', $getQuestionId);
    $stm->bindValue(':routeId', $sessionRouteId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

function getQuestionAnswer($questionId)
{
    include("databaseconnection.php");
    $queryAnswer = "SELECT * FROM `answer` WHERE questionId = :questionId";
    $stm = $con->prepare($queryAnswer);
    $stm->bindValue(':questionId', $questionId);
    if ($stm->execute()) {
        $resultAnswer = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $resultAnswer;
}

function getAwnserCount($questionId){
    include("databaseconnection.php");
    $queryAnswer = "SELECT count(*) AS count FROM `answer` WHERE questionId = :questionId";
    $stm = $con->prepare($queryAnswer);
    $stm->bindValue(':questionId', $questionId);
    if ($stm->execute()) {
        $resultAnswer = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $resultAnswer;
}

function deleteQuestion($questionId){
    include("databaseconnection.php");
    $queries = ["DELETE FROM `answer` WHERE questionId = :questionId", "DELETE FROM `question` WHERE questionId = :questionId"];
    foreach ($queries as $query){
        $stm = $con->prepare($query);
        $stm->bindValue(':questionId', $questionId);
        $stm->execute();
    }
    return true;
}