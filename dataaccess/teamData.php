<?php
function startRoute($teamName, $teamMembers, $somevar)
{
    include("databaseconnection.php");
    $query = "INSERT INTO `team`(`name`, `members`, `score`, `time`, `routeId`) VALUES (:teamName,:teamMembers,0,NOW(), :routeId)";
    $stm = $con->prepare($query);
    $stm->bindValue(':teamName', $teamName);
    $stm->bindValue(':teamMembers', $teamMembers);
    $stm->bindValue(':routeId', $somevar);
    $stm->execute();
}
