<?php 
include("./dataaccess/databaseconnection.php");
include("./dataaccess/routeData.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/detail.css">
    <title>AvansApp</title>
</head>
<body>
    <?php include("templates/header.php"); ?>
    <main>
        <div class="wrap row detailWrap">
        <?php
            include("./dataaccess/databaseconnection.php");
            // variable id ophalen uit url
            $somevar = $_GET["id"];
            // query op routeid gebaseert op id uit url
            $query = "SELECT * FROM `route` WHERE `routeId` = " . $somevar;
            $stm = $con->prepare($query);
            if ($stm->execute()) {
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                foreach ($result as $route) { 
                    if(!$route->picture == null){
                    $url = "data:image/jpeg;base64,".base64_encode($route->picture) ?>

                    
                    <div class="col-12 col-md-4 img" style="background-image:url('<?php echo $url ?>')"></div>

                    <?php } ?>
                    <div class="details col-12 <?php if(!$route->picture == null){echo "col-md-8";}?>" style="<?php if(!$route->picture == null){echo "padding-left: 45px;";} ?>">
                        <div class="header">
                            <h1 class="black"><?php echo $route->routeName ?></h1>
                            <p class="large">TODO: coursename</p>
                        </div>
                        <div class="content">
                            <p><?php echo $route->description ?></p>
                            <p class="large">TODO: date</p>
                        </div>
                    </div>
                    <div class="col-12 questions">
                        <div class="header">
                            <p class="large">
                                {AANTAL VRAGEN} vragen
                            </p>
                        </div>
                    </div>

            <?php }} ?>
        </div>
    </main>
</body>
<?php
// include("./dataaccess/databaseconnection.php");
// // variable id ophalen uit url
// $somevar = $_GET["id"];
// // query op routeid gebaseert op id uit url
// $query = "SELECT * FROM `route` WHERE `routeId` = " . $somevar;
// $stm = $con->prepare($query);
// if ($stm->execute()) {
//     $result = $stm->fetchAll(PDO::FETCH_OBJ);
//     foreach ($result as $route) {

//         echo $route->routeId;
//         echo " ";
//         echo $route->routeName;
//         echo "<br/>";
//         $query = "SELECT `courseName` FROM `course` WHERE `courseId` = $route->courseId;";
//         $stm = $con->prepare($query);
//         if ($stm->execute()) {
//             $result = $stm->fetchAll(PDO::FETCH_OBJ);
//             foreach ($result as $course) {
//                 echo $course->courseName;
//             }
//         }
//         echo "<br/>";
//         echo $route->description;
//         echo "<img src='data:image/jpeg;base64, " . base64_encode($route->picture) . "' alt='No film found' class='card-image'>";
//         echo "<br/>---------------------<br/>";
//     }
// }
?>
