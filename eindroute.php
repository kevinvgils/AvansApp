<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/teamData.php");
include("./dataaccess/courseData.php");

session_start();
$teamId = $_SESSION['teamId'];
$routeId = $_SESSION['routeId'];
endRoute($teamId);
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
            foreach(getTeamScore($teamId) as $team){      
        ?>
        <div class="wrap">
            <div class="item mobilecentered">
                <div class="itemWrap">
                        <div class="itemHeader">
                            <h3>Eind score: <?php echo $team->name; ?></h3>
                        </div>

                        <div class="itemContent">
                            <?php 
                            
                            $teamName = $team->name;
                            $sTime = strtotime($team->startTime);
                            $eTime = strtotime($team->endTime);
                            $totalTime = ($eTime-$sTime) / 60;
                            
                            ?> <p>Score: <strong id="teamScore"></strong><p/><?php
                            echo "Begintijd: ";
                            echo date('H:i:s', strtotime($team->startTime));
                            echo "<br/> Eindtijd: ";
                            echo date('H:i:s', strtotime($team->endTime));
                            echo "<br/>";
                            echo "Totale tijd: ";
                            echo number_format($totalTime, 2, '.', ',');
                            echo " min <br/>";
                            }

                            $position = 0;
                            foreach(getPositionLeaderBoard($routeId) as $leaderboard){
                                
                                $position++;
                                if($teamName == $leaderboard->name){
                                   
                                echo "Plek ";    
                                echo $position;
                                echo " van de ";
                                }
                            }

                            foreach(getAmountStoppedTeams($routeId) as $AmountOfTeams){
                                echo $AmountOfTeams->Amount;
                                echo " teams";
                            }
                            
                            ?>  
                        </div>
                    </div>
                </div>
            </div>
    </main>
</body>

<script>
    function animateValue(obj, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
        window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

    const obj = document.getElementById("teamScore");
    animateValue(obj, 0, <?php echo $team->score; ?>, 2500);
</script>

</html>