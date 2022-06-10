<?php
function startRoute($teamName, $teamMembers, $somevar, $array)
{
    $allmembers = "";
    foreach ($array as $member) {
        if (!empty($member)) {
            $allmembers .= $member . ",";
        }
    }

    include("databaseconnection.php");
    $query = "INSERT INTO `team`(`name`, `members`, `score`, `time`, `routeId`) VALUES (:teamName,:teamMembers,0,NOW(), :routeId)";
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

function getEndTime($teamId)
{

    include("databaseconnection.php");
    $allRoutesQuery = "SELECT TIMEDIFF(`endTime`,`startTime`) AS finalTime from team WHERE id = $teamId";
    $stm = $con->prepare($allRoutesQuery);
    if ($stm->execute()) {
        $allteams = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $allteams;
}
