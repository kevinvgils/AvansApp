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
