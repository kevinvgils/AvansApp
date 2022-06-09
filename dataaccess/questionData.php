<?php
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

function addAnswersToQuestion($questionId, $allAnswers)
{
    include("databaseconnection.php");
    foreach($allAnswers as $answer) {
        if(!empty($answer[1])) {
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
?>