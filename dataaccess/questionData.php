<?php

use LDAP\Result;

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

function addQuestionToRoute($routeId, $questionType, $question, $description, $score, $latitude, $longitude, $image, $videoUrl, $allAnswers)
{
    include("databaseconnection.php");
    $query = "INSERT INTO `question`(`questionType`, `routeId`, `question`, `description`, `score`, `latitude`, `longitude`, `image`, `videoUrl`) VALUES (:questionType, :routeId, :question, :descr, :score, :latitude, :longitude, '$image', :videoUrl)";
    $stm = $con->prepare($query);
    $stm->bindValue(':questionType', $questionType);
    $stm->bindValue(':routeId', $routeId);
    $stm->bindValue(':question', $question);
    $stm->bindValue(':descr', $description);
    $stm->bindValue(':score', $score);
    $stm->bindValue(':latitude', (empty($latitude)) ? null : $latitude);
    $stm->bindValue(':longitude', (empty($longitude)) ? null : $longitude);
    $stm->bindValue(':videoUrl', (empty($videoUrl)) ? null : $videoUrl);

    $stm->execute();

    if($questionType == 0){
        $questionId = $con->lastInsertId();
        addAnswersToQuestion($questionId, $allAnswers);
    }
}


function updateQuestionToRoute($questionId, $routeId, $questionType, $question, $description, $score, $latitude, $longitude, $image, $videoUrl, $allAnswers){
    $imageString = "";
    if($image != null){
        $imageString = "`image`= '$image',";
    }
    include("databaseconnection.php");
    $query = "UPDATE `question`".
     " SET `questionType`=:questionType, `question`=:question, `description`=:descr, `score`=:score, `latitude`=:latitude, `longitude`=:longitude, $imageString `videoUrl`=:videoUrl".
     " WHERE `questionId`=:questionId;";
    $stm = $con->prepare($query);
    $stm->bindValue(':questionType', $questionType);
    $stm->bindValue(':question', $question);
    $stm->bindValue(':descr', $description);
    $stm->bindValue(':score', $score);
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

function getAwnserCount($questionId)
{
    include("databaseconnection.php");
    $queryAnswer = "SELECT count(*) AS count FROM `answer` WHERE questionId = :questionId";
    $stm = $con->prepare($queryAnswer);
    $stm->bindValue(':questionId', $questionId);
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
        $query = "INSERT INTO `team_question`(`teamId`, `questionId`, `multipleChoiceAnswer`) VALUES (:teamId, :questionId, :answer)";
    } else if ($questionType == 1) {
        $query = "INSERT INTO `team_question`(`teamId`, `questionId`, `openAnswer`) VALUES (:teamId, :questionId, :answer)";
    } else if ($questionType == 2) {
        $query = "INSERT INTO `team_question`(`teamId`, `questionId`, `imageAnswer`) VALUES (:teamId, :questionId, '$answer')";
    }
    $stm = $con->prepare($query);
    $stm->bindValue(':teamId', $sessionTeamId);
    $stm->bindValue(':questionId', $getQuestionId);
    if($questionType != 2) {
        $stm->bindValue(':answer', $answer);
    }
    $stm->execute();
}

function getQuestionPoints($questionId) {
    include("databaseconnection.php");
    
    $query = "SELECT `score` FROM `question` WHERE `questionId` = :questionId";
    $stm = $con->prepare($query);
    $stm->bindValue(':questionId', $questionId);
        if ($stm->execute()) {
        $score = $stm->fetchAll(PDO::FETCH_OBJ);
    }

    return $score[0]->score;
}

function checkAnswer($answer, $correctAnswer, $questionId, $sessionTeamId, $score)
{
    include("databaseconnection.php");


    if (intval($answer) == intval($correctAnswer)) {
        $query = "UPDATE `team_question` SET `correct` = 1 WHERE `teamId` = :teamId AND `questionId` = :questionId";
        $stm = $con->prepare($query);
        $stm->bindValue(':teamId', $sessionTeamId);
        $stm->bindValue(':questionId', $questionId);
        $stm->execute();
        addPoints($sessionTeamId, $score);
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
    $query = "SELECT * FROM `team_question` WHERE `questionId` = $questionId AND `teamId` = :sessionTeamId;";
    $stm = $con->prepare($query);
    $stm->bindValue(':sessionTeamId', $sessionTeamId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

function gradeQuestion($id, $teamId, $isCorrect, $score)
{
    include("databaseconnection.php");
    $query = "UPDATE `team_question` SET `correct` = :isCorrect WHERE `id` = :id";
    $stm = $con->prepare($query);
    $stm->bindValue(':id', $id);
    $stm->bindValue(':isCorrect', $isCorrect);
    $stm->execute();

    if($isCorrect == 0){
        subtractPoints($teamId, $score);
    }
}

function isQuestionChecked($teamId, $questionId){
    include("databaseconnection.php");

    $query = "SELECT `correct` FROM `team_question` WHERE `teamId` = :teamId AND `questionId` = :questionId";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamId', $teamId);
    $stm->bindValue(':questionId', $questionId);
    if ($stm->execute()) {
        $isChecked = $stm->fetchAll(PDO::FETCH_OBJ);
    }

    return $isChecked[0]->correct;
}

function subtractPoints($sessionTeamId, $score)
{
    include("databaseconnection.php");
    $query = "UPDATE `team` SET `score` = score - :score WHERE `id` = :sessionTeamId;";
    $stm = $con->prepare($query);
    $stm->bindValue(':score', $score, PDO::PARAM_INT);
    $stm->bindValue(':sessionTeamId', $sessionTeamId);
    $stm->execute();
}

function addPoints($sessionTeamId, $score)
{
    include("databaseconnection.php");
    $query = "UPDATE `team` SET `score` = score + :score WHERE `id` = :sessionTeamId;";
    $stm = $con->prepare($query);
    $stm->bindValue(':score', $score);
    $stm->bindValue(':sessionTeamId', $sessionTeamId);
    $stm->execute();
}

function getAllAnswersForTeam($teamId)
{
    include("databaseconnection.php");
    $query = "SELECT * FROM team_question
    WHERE teamId = :teamId";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamId', $teamId);
    if ($stm->execute()) {
        $answers = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $answers;
}

function getMultipleChoiseAwnser($id){
    include("databaseconnection.php");
    $query = "SELECT * FROM answer
    WHERE answerId = :answerId";
    $stm = $con->prepare($query);
    $stm->bindValue(':answerId', $id);
    if ($stm->execute()) {
        $answers = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $answers;
}