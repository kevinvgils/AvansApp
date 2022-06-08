<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/teamData.php");
include("./dataaccess/courseData.php");

if (isset($_POST["btnOpslaan"])) {
    $teamName = $_POST["txtTeamName"];
    $teamMembers = $_POST["txtlid1"] . ", " .  $_POST["txtlid2"] . ", " .  $_POST["txtlid3"] . ", " .  $_POST["txtlid4"] . ", " .  $_POST["txtlid5"] . ", " .  $_POST["txtlid6"];
    $somevar = $_GET["id"];
    startRoute($teamName, $teamMembers, $somevar);

    session_start();
    $_SESSION['routeId'] = $somevar;

    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/addRoute.css">
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/header.php"); ?>
    <main>
        <?php
        $somevar = $_GET["id"];
        // query op routeid gebaseert op id uit url
        $query = "SELECT * FROM `route` WHERE `routeId` = " . $somevar;
        $stm = $con->prepare($query);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $route) {
        ?>
                <div class="wrap">

                    <div class="item mobilecentered">
                        <div class="itemWrap">
                            <div class="itemHeader">
                                <h3>Route <?php echo $route->routeName ?> starten</h3>
                            </div>
                            <div class="itemContent">
                                <form method="POST" class="addRouteForm" enctype="multipart/form-data">
                                    <label>Team naam</label>
                                    <input name="txtTeamName" type="text" placeholder="Team naam..." required>

                                    <label>Teamlid 1</label>
                                    <input name="txtlid1" type="text" placeholder="Teamlid 1">
                                    <label>Teamlid 2</label>
                                    <input name="txtlid2" type="text" placeholder="Teamlid 2">
                                    <label>Teamlid 3</label>
                                    <input name="txtlid3" type="text" placeholder="Teamlid 3">
                                    <label>Teamlid 4</label>
                                    <input name="txtlid4" type="text" placeholder="Teamlid 4">
                                    <label>Teamlid 5</label>
                                    <input name="txtlid5" type="text" placeholder="Teamlid 5">
                                    <label>Teamlid 6</label>
                                    <input name="txtlid6" type="text" placeholder="Teamlid 6">
                                    <input type="submit" name="btnOpslaan" value="Route starten" class="button buttonWrap">
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
        <?php }
        } ?>
    </main>
</body>

</html>