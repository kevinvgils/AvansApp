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
    $activeTeamsQuery = "SELECT * FROM `team` WHERE `endTime` IS NULL AND `routeId` = $routeId";
    $stm = $con->prepare($activeTeamsQuery);
    if ($stm->execute()) {
        $activeTeams = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $activeTeams;
}

function getAllFinishedTeamsInRoute($routeId) {
    include("databaseconnection.php");
    $finishedTeamsQuery = "SELECT * FROM `team` WHERE `endTime` IS NOT NULL AND `routeId` = $routeId";
    $stm = $con->prepare($finishedTeamsQuery);
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
