<?php

use LDAP\Result;

function getAllQuestionsForRoute($routeId)
{
    include("databaseconnection.php");
    $intRouteId = (int)$routeId;
    $allQuestionsQuery = "SELECT * FROM `question` WHERE `routeId` =" . $intRouteId;
    $stm = $con->prepare($allQuestionsQuery);
    if ($stm->execute()) {
        $allQuestions = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allQuestions;
}

function addQuestionToRoute($routeId, $question, $description, $latitude, $longitude, $image, $videoUrl, $allAnswers)
{
    include("databaseconnection.php");
    $query = "INSERT INTO `question`(`routeId`, `question`, `description`, `latitude`, `longitude`, `image`, `videoUrl`) VALUES (:routeId, :question, :descr, :latitude, :longitude, '$image', :videoUrl)";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $routeId);
    $stm->bindValue(':question', $question);
    $stm->bindValue(':descr', $description);
    $stm->bindValue(':latitude', (empty($latitude)) ? null : $latitude);
    $stm->bindValue(':longitude', (empty($longitude)) ? null : $longitude);
    $stm->bindValue(':videoUrl', (empty($videoUrl)) ? null : $videoUrl);

    $stm->execute();

    $questionId = $con->lastInsertId();
    addAnswersToQuestion($questionId, $allAnswers);
}

function updateQuestionToRoute($questionId, $routeId, $question, $description, $latitude, $longitude, $image, $videoUrl, $allAnswers)
{
    $imageString = "";
    if ($image != null) {
        $imageString = "`image`= $image,";
    }
    include("databaseconnection.php");
    $query = "UPDATE `question`" .
        " SET `question`=:question, `description`=:descr, `latitude`=:latitude, `longitude`=:longitude, $imageString `videoUrl`=:videoUrl" .
        " WHERE `questionId`=:questionId;";
    $stm = $con->prepare($query);
    $stm->bindValue(':question', $question);
    $stm->bindValue(':descr', $description);
    $stm->bindValue(':latitude', (empty($latitude)) ? null : $latitude);
    $stm->bindValue(':longitude', (empty($longitude)) ? null : $longitude);
    $stm->bindValue(':videoUrl', (empty($videoUrl)) ? '' : $videoUrl);
    $stm->bindValue(':questionId', $questionId, PDO::PARAM_INT);
    $stm->execute();

    deleteAllAnswersToQuestion($questionId);
    addAnswersToQuestion($questionId, $allAnswers);
}

function deleteAllAnswersToQuestion($questionId)
{
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
    $allAnswersQuery = "SELECT * FROM `answer` WHERE `questionId` =" . $intQuestionId;
    $stm = $con->prepare($allAnswersQuery);
    if ($stm->execute()) {
        $allAnswers = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allAnswers;
}

function getRouteName($sessionRouteId)
{
    include("databaseconnection.php");


    $query = "SELECT * FROM `route` WHERE `routeId` = " . $sessionRouteId;
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }

    return $result;
}
function getGlobalQuestion($sessionRouteId)
{
    include("databaseconnection.php");


    $query = "SELECT * FROM `question` WHERE `longitude` IS NULL AND `routeId` = " . $sessionRouteId;
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}
function getLocalQuestion($sessionRouteId)
{
    include("databaseconnection.php");

    $query = "SELECT * FROM `question` WHERE `longitude` IS NOT NULL AND `routeId` = " . $sessionRouteId;
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }

    return $result;
}

function getLocationCheck($getRouteId)
{
    include("databaseconnection.php");
    $query = "SELECT * FROM `question` WHERE `longitude` IS NOT NULL AND `latitude` IS NOT NULL AND `routeId` =" . $getRouteId;
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}
function getQuestionDetails($getQuestionId, $sessionRouteId)
{
    include("databaseconnection.php");
    $query = "SELECT * FROM `question` WHERE `questionId` =" . $getQuestionId . "  AND `routeId` = $sessionRouteId ";
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

function getQuestionAnswer($questionId)
{
    include("databaseconnection.php");
    $queryAnswer = "SELECT * FROM `answer` WHERE questionId =" . $questionId;
    $stm = $con->prepare($queryAnswer);
    if ($stm->execute()) {
        $resultAnswer = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $resultAnswer;
}

function getAwnserCount($questionId)
{
    include("databaseconnection.php");
    $queryAnswer = "SELECT count(*) AS count FROM `answer` WHERE questionId =" . $questionId;
    $stm = $con->prepare($queryAnswer);
    if ($stm->execute()) {
        $resultAnswer = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $resultAnswer;
}

function deleteQuestion($questionId)
{
    include("databaseconnection.php");
    $queries = ["DELETE FROM `answer` WHERE questionId = :questionId", "DELETE FROM `question` WHERE questionId = :questionId"];
    foreach ($queries as $query) {
        $stm = $con->prepare($query);
        $stm->bindValue(':questionId', $questionId);
        $stm->execute();
    }
    return true;
}

function answerQuestion($sessionTeamId, $getQuestionId, $questionType, $answer)
{
    include("databaseconnection.php");

    $query = "";
    if ($questionType == 0) {
        $query = "INSERT INTO `team_question`(`teamId`, `questionId`, `multipleChoiceAnswer`) VALUES ($sessionTeamId, $getQuestionId, $answer)";
    } else if ($questionType == 1) {
        $query = "INSERT INTO `team_question`(`teamId`, `questionId`, `openAnswer`) VALUES ($sessionTeamId, $getQuestionId, $answer)";
    } else if ($questionType == 2) {
        $query = "INSERT INTO `team_question`(`teamId`, `questionId`, `imageAnswer`) VALUES ($sessionTeamId, $getQuestionId, '$answer')";
    } else if ($questionType == 3) {
        $query = "INSERT INTO `team_question`(`teamId`, `questionId`, `videoAnswer`) VALUES ($sessionTeamId, $getQuestionId, '$answer')";
    }
    $stm = $con->prepare($query);
    $stm->execute();
}

function checkAnswer($answer, $correctAnswer, $questionId, $sessionTeamId)
{
    include("databaseconnection.php");

    if (intval($answer) == intval($correctAnswer)) {
        $query = "UPDATE `team_question` SET `correct` = 1 WHERE `teamId` = :teamId AND `questionId` = :questionId";
        $stm = $con->prepare($query);
        $stm->bindValue(':teamId', $sessionTeamId);
        $stm->bindValue(':questionId', $questionId);
        $stm->execute();
        addPoints($sessionTeamId);
    } else {
        $query = "UPDATE `team_question` SET `correct` = 0 WHERE `teamId` = :teamId AND `questionId` = :questionId";
        $stm = $con->prepare($query);
        $stm->bindValue(':teamId', $sessionTeamId);
        $stm->bindValue(':questionId', $questionId);
        $stm->execute();
    }
}

function checkIfAnswered($questionId, $sessionTeamId)
{
    include("databaseconnection.php");
    $query = "SELECT * FROM `team_question` WHERE `questionId` = $questionId AND `teamId` = $sessionTeamId;";
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    if (!$result) {
        return true;
    } else {
        return false;
    }
}
function addPoints($sessionTeamId)
{
    include("databaseconnection.php");
    $query = "UPDATE `team` SET `score` = score+100 WHERE `id` = $sessionTeamId;";
    $stm = $con->prepare($query);
    $stm->execute();
}
