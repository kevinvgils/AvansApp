<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/teamData.php");
include("./dataaccess/courseData.php");

if (isset($_POST["btnOpslaan"])) {
    $teamName = $_POST["txtTeamName"];
    $teamMembers = $_POST["txtTeamMembers"];
    $somevar = $_GET["id"];
    startRoute($teamName, $teamMembers, $somevar);

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

                    <div class="item mobilecentered ">
                        <div class="itemWrap">
                            <div class="itemHeader">
                                <h3>Route <?php echo $route->routeName ?> starten</h3>
                            </div>
                            <div class="itemContent">
                                <form method="POST" class="addRouteForm" enctype="multipart/form-data">
                                    <label>Team naam</label>
                                    <input name="txtTeamName" type="text" placeholder="Team naam..." required>

                                    <label>Team leden</label>
                                    <textarea id="txtTeamMembers" name="txtTeamMembers" rows="4" cols="50"></textarea>
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