<?php
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");
include("../dataaccess/teamData.php");
include("../dataaccess/questionData.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/runningroutes.css">
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/runningroutesheader.php"); ?>
    <main>
        <div class="wrap row">
        <?php
            foreach (getAllFinishedTeamsInRoute($_GET['id']) as $team) { ?>
                <div class="col-12 mb-3">
                    <div class="itemWrap">
                        <button type="button" class="collapsible itemHeader">
                            <img src="../img/down-arrow.png" alt="Down Arrow" width="30" height="30">
                            <h3 class="collapsible-text"><?php echo $team->name; ?> | Voltooid</h3>
                            <h3 class="collapsible-points"><?php echo $team->score ?> punten</h3>
                        </button>
                        <div class="collapsible-content">
                            <div class="toptext">
                                <h5><strong>Teamleden:</strong> <?php echo $team->members; ?> </h5>
                                <h5><strong>Voltooid in:</strong> <?php foreach (getEndTime($team->id) as $time) { echo $time->finalTime; }?></h5>
                            </div>
                            <?php
                            $i = 1;
                            foreach (getAllQuestionsForRoute($_GET['id']) as $question) { ?>
                                <div class="fullwidth" style="border-bottom: solid black 1px; margin-bottom: 20px; padding-bottom: 20px;">
                                    <div class="row">
                                        <div class="col-9">
                                            <p class="font-weight-bold">Vraag <?php echo $i . ": " . $question->question;
                                            $i++; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
            foreach (getAllActiveTeamsInRoute($_GET['id']) as $team) { ?>
                <div class="col-12 mb-3">
                    <div class="itemWrap">
                        <button type="button" class="collapsible itemHeader">
                            <img src="../img/down-arrow.png" alt="Down Arrow" width="30" height="30">
                            <h3 class="collapsible-text"><?php echo $team->name; ?> | </h3>
                            <div class="dot-pulse"></div>
                            <h3 class="collapsible-points"><?php echo $team->score ?> punten</h3>
                        </button>
                        <div class="collapsible-content">
                            <div class="toptext">
                                <h5 class="members-text"><strong>Teamleden:</strong> <?php echo $team->members; ?> </h5>
                            </div>
                            <?php
                            $i = 1;
                            foreach (getAllQuestionsForRoute($_GET['id']) as $question) { ?>
                                <div class="fullwidth" style="border-bottom: solid black 1px; margin-bottom: 20px; padding-bottom: 20px;">
                                    <div class="row">
                                        <div class="col-9">
                                            <p class="font-weight-bold">Vraag <?php echo $i . ": " . $question->question;
                                            $i++; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>

<!-- JS code -->
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
</script>
<!-- JS code -->