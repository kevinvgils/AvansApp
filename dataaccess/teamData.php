<?php
function startRoute($teamName, $teamMembers, $somevar, $array)
{
    $allmembers = "";
    foreach ($array as $member) {
        if (!empty($member)) {
            $allmembers .= $member . ", ";
        }
    }
    $allmembers = substr($allmembers, 0, -2);

    include("databaseconnection.php");
    $query = "INSERT INTO `team`(`name`, `members`, `score`, `startTime`, `endTime`, `routeId`) VALUES (:teamName,:teamMembers,0,NOW(),NULL, :routeId)";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamName', $teamName);
    $stm->bindValue(':teamMembers', $allmembers);
    $stm->bindValue(':routeId', $somevar);
    $stm->execute();
}

function getAllTeams() {
    include("databaseconnection.php");
    $allTeamsQuery = "SELECT * FROM `team`";
    $stm = $con->prepare($allTeamsQuery);
    if ($stm->execute()) {
        $allTeams = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allTeams;
}

function getAllActiveTeamsInRoute($routeId) {
    include("databaseconnection.php");
    $activeTeamsQuery = "SELECT * FROM `team` WHERE `endTime` IS NULL AND `routeId` = :routeId";
    $stm = $con->prepare($activeTeamsQuery);
    $stm->bindValue(':routeId', $routeId);
    if ($stm->execute()) {
        $activeTeams = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $activeTeams;
}

function getAllFinishedTeamsInRoute($routeId) {
    include("databaseconnection.php");
    $finishedTeamsQuery = "SELECT * FROM `team` WHERE `endTime` IS NOT NULL AND `routeId` = :routeId";
    $stm = $con->prepare($finishedTeamsQuery);
    $stm->bindValue(':routeId', $routeId);
    if ($stm->execute()) {
        $finishedTeams = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $finishedTeams;
}

function getEndTime($teamId) {
    include("databaseconnection.php");
    $endTimeQuery = "SELECT TIMEDIFF(`endTime`,`startTime`) AS `finalTime` FROM `team` WHERE `id` = :teamId";
    $stm = $con->prepare($endTimeQuery);
    $stm->bindValue(':teamId', $teamId);
    if ($stm->execute()) {
        $endTime = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $endTime;
}

function endRoute($teamId)
{
    include("databaseconnection.php");

    $query = "UPDATE `team` SET `endTime` = NOW(), `isActive` = 0 WHERE `id` = :teamId AND isActive = 1";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamId', $teamId);
    $stm->execute();

}

function getTeamId($teamName){
    include("databaseconnection.php");

    $query = "SELECT `id` FROM `team` WHERE `name` = :name";
    $stm = $con->prepare($query);
    $stm->bindValue(':name', $teamName);
    if ($stm->execute()) {
        $teamId = $stm->fetchAll(PDO::FETCH_OBJ);
        
        
    }
    return $teamId;
}

function getTeamScore($teamId){
    include("databaseconnection.php");

    $query = "SELECT * FROM `team` WHERE `id` = :teamId";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamId', $teamId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

function getPositionLeaderBoard($routeId){
    include("databaseconnection.php");

    $query = "SELECT * FROM `team` WHERE routeId = :routeId AND `isActive` = 0 ORDER BY `score` DESC";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $routeId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

function getAmountStoppedTeams($routeId){
    include("databaseconnection.php");

    $query = "SELECT COUNT(*) AS 'Amount' FROM `team` WHERE routeId = :routeId AND isActive = 0";
    $stm = $con->prepare($query);
    $stm->bindValue(':routeId', $routeId);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}


function checkTeamName($teamName) {
    include("databaseconnection.php");

    $query = "SELECT * FROM `team` WHERE `name` = :teamName";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamName', $teamName);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}