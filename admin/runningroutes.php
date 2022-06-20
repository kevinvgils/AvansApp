<?php
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");
include("../dataaccess/teamData.php");
include("../dataaccess/questionData.php");

if (isset($_POST["button"]) && $_POST["button"] != null) {
    $id = $_GET['id'];
    if($_POST["button"] == "Goed"){

        gradeQuestion($_POST['id'], $_POST['teamId'], 1, getQuestionPoints($_POST["questionId"]));
        
    } else if($_POST["button"] == "Fout"){
        if(isQuestionChecked($_POST['teamId'], $_POST["questionId"]) === null){
            gradeQuestion($_POST['id'], $_POST['teamId'], 0, getQuestionPoints($_POST["questionId"]));
        }
    }
}

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
        <?php $id = $_GET['id'] ?>


        <div class="wrap row">

            <div class="col-11 mb-4">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kies een datum!
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="runningroutes.php?id=<?php echo $id; ?>">Alle datums</a>
                        <div class="dropdown-divider"></div>
                        <?php
                        $datearray = [];
                        foreach (getAllTeams() as $team) { ?>

                            <?php
                            $date = $team->startDate;

                            if (!in_array($date, $datearray)) {
                                $datearray[] = $date;
                            ?>
                                <a class="dropdown-item" href="runningroutes.php?id=<?php echo $id; ?>&startTime=<?php echo $date ?>"><?php echo $date; ?></a>
                            <?php
                            }

                            ?>

                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
            $startTime = (empty($_GET["startTime"])) ? null : $_GET["startTime"];

            foreach ((empty($startTime)) ? getAllFinishedTeamsInRoute($_GET['id']) : getAllFinishedTeamsInRouteWithTime($_GET['id'], $startTime) as $team) { ?>
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
                                <h5><strong>Voltooid in:</strong> <?php foreach (getEndTime($team->id) as $time) {
                                                                        echo $time->finalTime;
                                                                    } ?></h5>
                            </div>
                            <?php
                            $i = 1;
                            $answers = getAllAnswersForTeam($team->id);
                            foreach (getAllQuestionsForRoute($_GET['id']) as $question) {
                                $key = array_search($question->questionId, array_column($answers, 'questionId')); ?>
                                <div class="fullwidth" style="border-bottom: solid black 1px; margin-bottom: 20px; padding-bottom: 20px;">
                                    <p <?php
                                        if ($key === false) {
                                        } else if ($answers[$key]->correct === 1) {
                                            var_dump($key);
                                            echo "style=\"color: green\"";
                                        } else if ($answers[$key]->correct === 0 && $answers[$key]->correct !== NULL) {
                                            var_dump($answers[$key]->correct);
                                            echo "style=\"color: red\"";
                                        } else if ($answers[$key]->correct === NULL) {
                                            echo "style=\"color: orange\"";
                                        } ?> class="font-weight-bold">Vraag <?php echo $i . ": " . $question->question;
                                                                            $i++; ?></p>
                                    <?php if ($key !== false) { ?>
                                        <p>Antwoord:
                                            <?php
                                            if ($question->questionType == 1) {
                                                echo $answers[$key]->openAnswer;
                                            } else if ($question->questionType == 0) {
                                                echo getMultipleChoiseAwnser($answers[$key]->multipleChoiceAnswer)[0]->answer;
                                            }
                                            ?></p>
                                        <?php if ($question->questionType == 2) {
                                            $img = "data:image/jpeg;base64," . base64_encode($answers[$key]->imageAnswer) ?>
                                            <img src="<?php echo $img; ?>" alt="antwoord afbeelding" width="150" height="150">
                                        <?php } else if ($question->questionType == 3) { ?>
                                            <p>Video</p>
                                        <?php }
                                    } else { ?>
                                        <p>Vraag niet beantwoord</p>
                                    <?php } ?>

                                    <div class="buttonWrap">
                                        <?php if($answers[$key]->correct === null){ ?>
                                            <form method="POST" enctype="multipart/form-data"><input type="hidden" name="questionId" value="<?php echo $question->questionId; ?>"><input type="hidden" name="teamId" value="<?php echo $answers[$key]->teamId; ?>"><input type="hidden" name="id" value="<?php echo $answers[$key]->id; ?>"><input class="button" name="button" type="submit" value="Goed"></form>
                                            <form method="POST" enctype="multipart/form-data"><input type="hidden" name="questionId" value="<?php echo $question->questionId; ?>"><input type="hidden" name="teamId" value="<?php echo $answers[$key]->teamId; ?>"><input type="hidden" name="id" value="<?php echo $answers[$key]->id; ?>"><input class="button" name="button" type="submit" value="Fout"></form>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php

            foreach ((empty($startTime)) ? getAllActiveTeamsInRoute($_GET['id']) : getAllActiveTeamsInRouteWithTime($_GET['id'], $startTime) as $team) { ?>
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
                                <h5><strong>Teamleden:</strong> <?php echo $team->members; ?> </h5>
                            </div>
                            <?php
                            $i = 1;
                            $answers2 = getAllAnswersForTeam($team->id);
                            //var_dump($answers2);
                            foreach (getAllQuestionsForRoute($_GET['id']) as $question) {
                                $key = array_search($question->questionId, array_column($answers2, 'questionId')); ?>
                                <div class="fullwidth" style="border-bottom: solid black 1px; margin-bottom: 20px; padding-bottom: 20px;">
                                    <p <?php
                                        if ($key === false) {
                                        } else if ($answers2[$key]->correct === 1) {
                                            var_dump($key);
                                            echo "style=\"color: green\"";
                                        } else if ($answers2[$key]->correct === 0 && $answers2[$key]->correct !== NULL) {
                                            var_dump($answers2[$key]->correct);
                                            echo "style=\"color: red\"";
                                        } else if ($answers2[$key]->correct === NULL) {
                                            echo "style=\"color: orange\"";
                                        } ?> class="font-weight-bold">Vraag <?php echo $i . ": " . $question->question;
                                                                            $i++; ?></p>
                                    <?php if ($key !== false) { ?>
                                        <p>Antwoord:
                                            <?php
                                            if ($question->questionType == 1) {
                                                echo $answers2[$key]->openAnswer;
                                            } else if ($question->questionType == 0) {
                                                echo getMultipleChoiseAwnser($answers2[$key]->multipleChoiceAnswer)[0]->answer;
                                            }
                                            ?></p>
                                        <?php if ($question->questionType == 2) {
                                            $img = "data:image/jpeg;base64," . base64_encode($answers2[$key]->imageAnswer) ?>
                                            <img src="<?php echo $img; ?>" alt="antwoord afbeelding" width="150" height="150">
                                        <?php } else if ($question->questionType == 3) { ?>
                                            <p>Video</p>
                                        <?php }
                                    } else { ?>
                                        <p>Vraag niet beantwoord</p>
                                    <?php } ?>

                                    <div class="buttonWrap">
                                        <?php
                                        if($answers2[$key]->correct === null){ ?>
                                            <form method="POST" enctype="multipart/form-data"><input type="hidden" name="teamId" value="<?php echo $answers2[$key]->teamId; ?>"><input type="hidden" name="questionId" value="<?php echo $question->questionId; ?>"><input type="hidden" name="id" value="<?php echo $answers2[$key]->id; ?>"><input class="button" name="button" type="submit" value="Goed"></form>
                                            <form method="POST" enctype="multipart/form-data"><input type="hidden" name="teamId" value="<?php echo $answers2[$key]->teamId; ?>"><input type="hidden" name="questionId" value="<?php echo $question->questionId; ?>"><input type="hidden" name="id" value="<?php echo $answers2[$key]->id; ?>"><input class="button" name="button" type="submit" value="Fout"></form>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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