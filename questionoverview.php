<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/routeData.php");
include("./dataaccess/courseData.php");
include("./dataaccess/questionData.php");
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
    ?>
    <main>
        <div class="wrap">

            <div class="item">
                <div class="itemWrap">
                    <div class="itemHeader">
                        <h3>
                            <?php

                            $sessionRouteId = $_SESSION["routeId"];
                            foreach (getRouteName($sessionRouteId) as $route) {
                                echo $route->routeName;
                            }
                            ?>
                        </h3>

                    </div>
                    <div class="itemContent">
                        <strong>Globale vragen</strong>
                        <p>
                            <?php
                            $sessionRouteId = $_SESSION["routeId"];
                            $questionCount = 1;

                            foreach (getGlobalQuestion($sessionRouteId) as $questions) {
                                echo $questionCount++ . ". ";
                            ?> <a onclick='changeUrl(<?php echo $sessionRouteId ?>, <?php echo $questions->questionId ?>)' data-toggle='modal' data-target='#myModal'><?php echo $questions->question ?></a>
                            <?php
                                echo "<br/>";
                            }

                            ?>
                        </p>
                        <br>
                        <strong>Locatie vragen</strong>
                        <p>
                            <?php
                            $sessionRouteId = $_SESSION["routeId"];
                            $questionCount = 1;


                            foreach (getLocalQuestion($sessionRouteId) as $questions) {
                                echo $questionCount++ . ". ";
                                echo $questions->question;
                                echo "<br/>";
                            }

                            ?>
                        </p>
                    </div>
                </div>
            </div>





            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white">Vraag details</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form method="POST" onsubmit="return validateForm()">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 border-right col-md-6 media-full-width">


                                            <?php
                                            $sessionRouteId = $_SESSION["routeId"];
                                            $getQuestionId = $_GET["questionId"];

                                            foreach (getQuestionDetails($getQuestionId, $sessionRouteId) as $questions) {
                                                echo $questions->question;
                                                echo "<br/><br/><strong>Bescrhijving: </strong><br/>";
                                                echo $questions->description;
                                                echo "<br/><br/>";
                                                if(!$questions->videoUrl == null){
                                                    echo "<iframe src='$questions->videoUrl' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                                                }
                                                
                                                if (!$questions->image == null) {
                                                    $url = "data:image/jpeg;base64," . base64_encode($questions->image) ?>


                                                    <div class="img" style="background-image:url('<?php echo $url ?>')"></div>


                                                <?php } ?>




                                        </div>
                                        <div class="col-12 col-md-6 answers">
                                            <p><strong>Antwoord mogelijkheden</strong></p>
                                        <?php
                                                $questionId = $questions->questionId;

                                                foreach (getQuestionAnswer($questionId) as $answers) {
                                                    echo $answers->answer;
                                                    echo "<br/>";
                                                }
                                            }
                                            echo "<br/>";


                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="addQuestion" class="btn btn-danger">Submit</button>
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
<script>
    <?php
    if (isset($_GET["questionId"])) { ?>
        $('#myModal').modal('show');
    <?php } ?>
</script>

</html>