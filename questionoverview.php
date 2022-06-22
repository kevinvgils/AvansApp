<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/routeData.php");
include("./dataaccess/courseData.php");
include("./dataaccess/questionData.php");
include("./dataaccess/teamData.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/vraagdetail.css">
    <title>AvansApp</title>
</head>

<body>
    <script>
        function changeUrl(routeId, questionId) {
            window.location.href = "./questionoverview.php?id=" + routeId + "&questionId=" + questionId;
        }
    </script>
    <?php include("templates/questionoverviewheader.php");
    session_start();
    include("../AvansApp/logic/sessionRedirect.php");
    $sessionRouteId = $_SESSION["routeId"];
    $sessionTeamId = $_SESSION["teamId"];
    foreach (getAllFinishedTeamsInRoute($sessionRouteId) as $team) {
        if ($team->id === $sessionTeamId) {
            header("Location: index.php");
            exit();
        }
    }
    ?>
    <main>
        <div class="wrap">
            <div class="item">
                <div class="itemWrap">
                    <div class="itemHeader">
                        <h3>
                            <?php

                            $sessionRouteId = $_SESSION["routeId"];
                            $sessionTeamId = $_SESSION["teamId"];

                            foreach (getRouteName($sessionRouteId) as $route) {

                                echo $route->routeName;
                            }
                            ?>
                        </h3>

                    </div>
                    <div class="itemContent">
                        <strong>Globale vragen</strong>
                        <ol>
                            <?php
                            $sessionRouteId = $_SESSION["routeId"];
                            //$questionCount = 1;
                            foreach (getGlobalQuestion($sessionRouteId) as $questions) {
                            ?>
                                <?php
                                if (checkIfAnswered($questions->questionId, $sessionTeamId) == true) {

                                ?><li class="questionli"> <a onclick='changeUrl(<?php echo $sessionRouteId ?>, <?php echo $questions->questionId ?>)' data-toggle='modal' data-target='#myModal'><?php echo $questions->question ?></a>
                                    </li>
                            <?php }
                            } ?>

                        </ol>

                        <strong>Locatie vragen</strong>
                        <ol>
                            <?php
                            $sessionRouteId = $_SESSION["routeId"];

                            foreach (getLocalQuestion($sessionRouteId) as $questions) {
                                if (checkIfAnswered($questions->questionId, $sessionTeamId) == true) {
                            ?><li class="questionli"> <?php echo $questions->question; ?></li>
                            <?php
                                }
                            }

                            ?>
                        </ol>
                        <div class="buttonWrap">
                            <!-- start knop waar routeId word megegeven -->
                            <div class="button stopButton" onclick="stopAlert()">Stoppen</div>
                            <script>
                                function stopAlert() {
                                    let text = "Weet u zeker dat u de route wilt stoppen?";
                                    if (confirm(text) == true) {
                                        window.location.href = "./eindroute.php";
                                    } else {
                                        window.location.href = "./questionoverview.php";
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-white">Vraag details</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 border-right col-md-6 media-full-width">

                                            <?php
                                            $sessionRouteId = $_SESSION["routeId"];
                                            $getQuestionId = $_GET["questionId"];

                                            foreach (getQuestionDetails($getQuestionId, $sessionRouteId) as $questions) {
                                                echo $questions->question;
                                                echo "<br/><br/><strong>Beschrijving : </strong><br/>";
                                                echo $questions->description;
                                                echo "<br/><br/>";
                                                if (!$questions->videoUrl == null) {
                                                    echo "<iframe src='$questions->videoUrl' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                                                }

                                                if (!$questions->image == null) {
                                                    $url = "data:image/jpeg;base64," . base64_encode($questions->image) ?>


                                                    <div class="img" style="background-image:url('<?php echo $url ?>')"></div>


                                                <?php } ?>

                                        </div>
                                        <div class="col-12 col-md-6 answers">
                                            <?php

                                                $questionType = $questions->questionType;

                                                if ($questions->questionType == 0) {

                                                    $answerCount = 1;

                                                    foreach (getQuestionAnswer($getQuestionId) as $answers) {
                                                        echo "<input type=\"radio\" value=\"{$answers->answerId}\" name=\"radio_btn\">";
                                                        echo "<label for=\"{$answerCount}\">{$answers->answer}</label>";
                                                        echo "<br>";

                                                        if ($answers->isCorrect != null) {
                                                            $correctAnswer = $answers->answerId;
                                                        }

                                                        $answerCount++;
                                                    }
                                                } elseif ($questions->questionType == 1) {
                                            ?>
                                                <textarea id="txtQuestionAnswer" name="txtQuestionAnswer" rows="4" cols="50" wrap="hard" maxlength="255"></textarea>
                                            <?php
                                                } elseif ($questions->questionType == 2) {
                                            ?>
                                                <label>Afbeelding uploaden</label>
                                                <input type="file" class="form-control-file" id="picture" name="picture">

                                        <?php
                                                }
                                            }
                                            echo "<br/>";
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btnAnswerQuestion" class="btn submit-btn">Opslaan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
</body>

<!-- JS code -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="./js/detailpage.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<!--JS below-->

<!--modal-->


<?php
$pictureQuestion = NULL;
$videoQuestion = NULL;
if (isset($_POST["btnAnswerQuestion"])) {

    $answer;
    if ($questionType == 0) {
        $answer = $_POST["radio_btn"];
    } elseif ($questionType == 1) {
        $answer = $_POST["txtQuestionAnswer"];
    } elseif ($questionType == 2) {
        $answer = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
    } elseif ($questionType == 3) {
        $answer = addslashes(file_get_contents($_FILES['video']['tmp_name']));
    }
    answerQuestion($sessionTeamId, $getQuestionId, $questionType, $answer);

    getQuestionPoints($getQuestionId);

    if ($questionType == 0) {
        checkAnswer($answer, $correctAnswer, $getQuestionId, $sessionTeamId, getQuestionPoints($getQuestionId));
    } else {
        addPoints($sessionTeamId, getQuestionPoints($getQuestionId));
    }

    echo "<meta http-equiv='refresh' content='0'>";
} elseif (checkIfAnswered($questions->questionId, $sessionTeamId) == true) {

    echo "<script>";
    if (isset($_GET["questionId"])) { ?>
        $('#myModal').modal('show');
<?php }
    echo "</script>";
}
?>

</html>