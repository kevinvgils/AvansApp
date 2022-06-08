<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/questionData.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://kit.fontawesome.com/72d4739e76.js" crossorigin="anonymous"></script>
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/header.php"); 
    session_start(); 
    ?>
    <div class="wrap">
        <div class="item">
            <div class="itemWrap">
                <div class="itemHeader">
                    <h3>
                        <?php include("./dataaccess/databaseconnection.php");
                        $somevar = $_SESSION["routeId"];
                        $query = "SELECT * FROM `route` WHERE `routeId` = " . $somevar;
                        $stm = $con->prepare($query);
                        if ($stm->execute()) {
                            $result = $stm->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result as $route) {
                                echo $route->routeName;
                            }
                        } ?>
                    </h3>

                </div>
                <div class="itemContent">
                    <strong>Globale vragen</strong>
                    <p>
                        <?php
                        $somevar = $_SESSION["routeId"];
                        $questionCount = 1;
                        $query = "SELECT * FROM `question` WHERE `longitude` IS NULL AND `routeId` = " . $somevar;
                        $stm = $con->prepare($query);
                        if ($stm->execute()) {
                            $result = $stm->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result as $questions) {
                                echo $questionCount++ . ". ";
                                echo $questions->question;
                                echo "<br/>";
                            }
                        }
                        ?>
                    </p>
                    <br>
                    <strong>Locatie vragen</strong>
                    <p>
                        <?php
                        $somevar = $_SESSION["routeId"];
                        $questionCount = 1;
                        $query = "SELECT * FROM `question` WHERE `longitude` IS NOT NULL AND `routeId` = " . $somevar;
                        $stm = $con->prepare($query);
                        if ($stm->execute()) {
                            $result = $stm->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result as $questions) {
                                echo $questionCount++ . ". ";
                                echo $questions->question;
                                echo "<br/>";
                            }
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>