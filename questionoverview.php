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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/72d4739e76.js" crossorigin="anonymous"></script>
    <title>AvansApp</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <?php $show_overview_button =  "<button type=\"button\" class=\"btn btn-light\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal\"><i class=\"fa-solid fa-bars\"></i></button>";
    include("templates/header.php"); ?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                        <?php include("./dataaccess/databaseconnection.php");
                        // $somevar = $_SESSION["routeId"];
                        $somevar = 1;

                        $query = "SELECT * FROM `route` WHERE `routeId` = " . $somevar;
                        $stm = $con->prepare($query);
                        if ($stm->execute()) {
                            $result = $stm->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result as $route) {
                                echo $route->routeName;
                            }
                        } ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="font-weight-bold">Globale vragen</h6>
                    <?php
                    // $somevar = $_SESSION["routeId"];
                    $somevar = 1;
                    $query = "SELECT * FROM `question` WHERE `longitude` IS NULL AND `routeId` = " . $somevar;

                    $stm = $con->prepare($query);
                    if ($stm->execute()) {
                        $result = $stm->fetchAll(PDO::FETCH_OBJ);
                        foreach ($result as $questions) {
                            echo $questions->question;
                            echo "<br/>";
                        }
                    }
                    ?>

                    <br>

                    <h6 class="font-weight-bold">Locatie vragen</h6>
                    <?php
                    // $somevar = $_SESSION["routeId"];
                    $somevar = 1;
                    $query = "SELECT * FROM `question` WHERE `longitude` IS NOT NULL AND `routeId` = " . $somevar;

                    $stm = $con->prepare($query);
                    if ($stm->execute()) {
                        $result = $stm->fetchAll(PDO::FETCH_OBJ);
                        foreach ($result as $questions) {
                            echo $questions->question;
                            echo "<br/>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>