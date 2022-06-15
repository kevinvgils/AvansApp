<?php
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");
include("../dataaccess/courseData.php");
include("../dataaccess/questionData.php");
include("../logic/adminRedirect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/header.php"); ?>
    <main>

        <div class="wrap row">
            <div class="col-12 mb-3">
                <a class="button px-3 py-1" href="addroute.php">
                    Add route
                </a>
            </div>
            <?php
            foreach (getAllRoutes() as $route) { ?>
                <div class="item col-12 col-md-6">
                    <div class="itemWrap">
                        <a href="detailpage.php?id=<?php echo $route->routeId; ?>" title>
                            <div class="itemHeader">
                                <h3><?php echo $route->routeName; ?></h3>
                                <p><?php echo count(getAllQuestionsForRoute($route->routeId)) . " vragen"; ?></p>
                            </div>
                        </a>
                        <div class="itemContent flexitem">
                            <?php foreach (getCourseById($route->courseId) as $course) { ?>
                                <div>
                                    <?php if (!$route->picture == null) {
                                        $url = "data:image/jpeg;base64," . base64_encode($route->picture) ?>
                                        <div class="img" style="background-image:url('<?php echo $url ?>')"></div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <p><?php echo $course->courseName; ?></p>
                                <?php } ?>
                                <p><?php echo $route->description ?> </p>
                                <div class="buttonWrap">
                                    <a href="runningroutes.php?id=<?php echo $route->routeId; ?>" class="button">Scores</a>
                                    <a href="/" class="button">Bewerken</a>
                                    <a href="/" class="button">Verwijderen</a>
                                </div>
                                </div>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>

</html>