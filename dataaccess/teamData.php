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
    $query = "INSERT INTO `team`(`name`, `members`, `score`, `startTime`, `routeId`) VALUES (:teamName,:teamMembers,0,NOW(), :routeId)";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamName', $teamName);
    $stm->bindValue(':teamMembers', $allmembers);
    $stm->bindValue(':routeId', $somevar);
    $stm->execute();
}

function endRoute($teamId)
{
    include("databaseconnection.php");

    $query = "UPDATE `team` SET `endTime` = NOW(), `isActive` = 0 WHERE `id` = $teamId AND isActive = 1";
    $stm = $con->prepare($query);
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

    $query = "SELECT * FROM `team` WHERE `id` = " . $teamId;
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

function getPositionLeaderBoard($routeId){
    include("databaseconnection.php");

    $query = "SELECT * FROM `team` WHERE routeId = $routeId AND `isActive` = 0 ORDER BY `score` DESC";
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}

function getAmountStoppedTeams($routeId){
    include("databaseconnection.php");

    $query = "SELECT COUNT(*) AS 'Amount' FROM `team` WHERE routeId = 1 AND isActive = 0";
    $stm = $con->prepare($query);
    if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_OBJ);
    }
    return $result;
}
