<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/teamData.php");
include("./dataaccess/courseData.php");

if (isset($_POST["btnOpslaan"])) {
    $teamName = $_POST["txtTeamName"];
    $teammembersarray = array(
        $_POST["txtlid1"],
        $_POST["txtlid2"],
        $_POST["txtlid3"],
        $_POST["txtlid4"],
        $_POST["txtlid5"],
        $_POST["txtlid6"],
        $_POST["txtlid7"],
        $_POST["txtlid8"]
    );
    $teamMembers = $_POST["txtlid1"] . ", " .  $_POST["txtlid2"] . ", " .  $_POST["txtlid3"] . ", " .  $_POST["txtlid4"] . ", " .  $_POST["txtlid5"] . ", " .  $_POST["txtlid6"] . ", " .  $_POST["txtlid7"] . ", " .  $_POST["txtlid8"];
    $somevar = $_GET["id"];

    if (count(checkTeamName($teamName)) == 0) {
        startRoute($teamName, $teamMembers, $somevar, $teammembersarray);
        foreach (getTeamId($teamName) as $team) {
            $teamId = $team->id;
        }
        session_start();
        $_SESSION['routeId'] = $somevar;
        $_SESSION['teamId'] = $teamId;

        header("Location: map.php");
        exit();
    } else {
        $_GET['error'] = "Teamnaam bestaat al!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/addRoute.css">
    <link rel="stylesheet" href="style/teamform.css">

    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/header.php"); ?>
    <main>
        <?php
        $error = null;
        $getRouteId = $_GET["id"];
        // query op routeid gebaseert op id uit url
        $query = "SELECT * FROM `route` WHERE `routeId` = " . $getRouteId;
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
                                    <?php if (isset($_GET['error'])) { ?><label class="error"><?php echo $_GET['error']; ?></label><?php } ?>
                                    <label>Team naam</label>
                                    <input name="txtTeamName" type="text" placeholder="Team naam..." required>
                                    <label>Aantal teamleden</label>
                                    <select class="mb-2 inputbox" onchange="showTeamFields(this)">
                                        <option selected value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                    <div class="team">
                                        <label for="txtlid1">Teamlid 1</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid1" id="team1Txt" type="text" placeholder="Teamlid 1" required>
                                        </div>
                                    </div>
                                    <div id="team2Div" class="team">
                                        <label for="txtlid2">Teamlid 2</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid2" id="team2Txt" type="text" placeholder="Teamlid 2">
                                        </div>
                                    </div>
                                    <div id="team3Div" class="team">
                                        <label for="txtlid3">Teamlid 3</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid3" id="team3Txt" type="text" placeholder="Teamlid 3">
                                        </div>
                                    </div>
                                    <div id="team4Div" class="team">
                                        <label for="txtlid4">Teamlid 4</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid4" id="team4Txt" type="text" placeholder="Teamlid 4">
                                        </div>
                                    </div>
                                    <div id="team5Div" class="team">
                                        <label for="txtlid5">Teamlid 5</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid5" id="team5Txt" type="text" placeholder="Teamlid 5">
                                        </div>
                                    </div>
                                    <div id="team6Div" class="team">
                                        <label for="txtlid6">Teamlid 6</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid6" id="team6Txt" type="text" placeholder="Teamlid 6">
                                        </div>
                                    </div>
                                    <div id="team7Div" class="team">
                                        <label for="txtlid7">Teamlid 7</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid7" id="team7Txt" type="text" placeholder="Teamlid 7">
                                        </div>
                                    </div>
                                    <div id="team8Div" class="team">
                                        <label for="txtlid8">Teamlid 8</label>
                                        <div class="input-group mb-2">
                                            <input name="txtlid8" id="team8Txt" type="text" placeholder="Teamlid 8">
                                        </div>
                                    </div>
                            </div>
                            <input type="submit" name="btnOpslaan" value="Route starten" class="button buttonWrap startbutton">
                            </form>
                        </div>
                    </div>
                </div>


                </div>
        <?php }
        } ?>
    </main>
</body>

<!-- JS code -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="./js/startroute.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<!--JS below-->

</html>