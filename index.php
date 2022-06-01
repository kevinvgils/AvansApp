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
    <title>AvansApp</title>
</head>
<body>
    <?php include("templates/header.php"); ?>
    <main>
        <div class="wrap row">
        <?php
            foreach (getAllRoutes() as $route) { ?>
                <div class="item col-12 col-md-6">
                    <div class="itemWrap">
                            <a href="detailpage.php?id=<?php echo $route->routeId; ?>" title>
                                <div class="itemHeader">
                                    <h3><?php echo $route->routeName; ?></h3>
                                    <p><?php echo "TODO: aantal vragen" ?></p>
                                </div>
                            </a>
                            <div class="itemContent">
                                <p><?php echo "TODO: opleiding" ?></p>
                                <p><?php echo $route->description ?> </p>
                                <div class="buttonWrap">
                                    <a href="/" class="button">Scores</a>
                                    <a href="/" class="button">Bewerken</a>
                                    <a href="/" class="button">Verwijderen</a>
                                </div>
                            </div>
                        
                    </div>
                </div>
        <?php }?>
        </div>
    </main>
</body>
</html>