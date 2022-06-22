<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/routeData.php");
include("./dataaccess/courseData.php");
include("./dataaccess/questionData.php");
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
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/header.php"); ?>
    <main>
        <div class="wrap row">
            <div class="col-11 mb-4">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kies je opleiding!
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index.php">Alle routes</a>
                        <div class="dropdown-divider"></div>
                        <?php
                        foreach (getCourses() as $course) { ?>
                            <a class="dropdown-item" href="index.php?courseId=<?php echo $course->courseId ?>"><?php echo $course->courseName ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
            $courseId = (empty($_GET["courseId"])) ? null : $_GET["courseId"];
            foreach ((empty($courseId)) ? getAllActiveRoutes() : getAllRoutesByCourse($courseId) as $route) { ?>
                <div class="item col-12 col-md-6">
                    <div class="itemWrap">
                        <!-- Titel van de route is klikbaar en word de routeId megegeven -->
                        <a href="startroute.php?id=<?php echo $route->routeId; ?>" title>
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
                                    <!-- start knop waar routeId word megegeven -->
                                    <a href="startroute.php?id=<?php echo $route->routeId; ?>" class="button">Starten</a>
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>