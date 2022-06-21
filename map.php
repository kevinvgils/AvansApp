<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/questionData.php");
include("./dataaccess/routeData.php");
include("./dataaccess/courseData.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/map.css">
    <title>AvansApp</title>

    <!-- leaflet css  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

</head>

<body>
    <?php include("templates/mapheader.php");
    session_start();
    include("../AvansApp/logic/sessionRedirect.php");
    $sessionRouteId = $_SESSION["routeId"];
    $sessionTeamId = $_SESSION["teamId"];
    ?>
    <div id="map"></div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Vraag details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
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
                                    } elseif ($questions->questionType == 3) {
                                ?>
                                    <label>Video uploaden</label>
                                    <input type="file" class="form-control-file" id="video" name="video">
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
                    <button type="submit" name="btnAnswerQuestion" class="btn submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>


<script>
    function changeUrl(questionId) {
        window.location.href = "./map.php?questionId=" + questionId;
    }

    //Test cords
    var coordAvansB = 51.5856651;
    var coordAvansL = 4.7922393;



    var avansIcon = L.icon({
        iconUrl: "img/LogoRed.png",

        iconSize: [60, 50]
    });

    var avansPin = L.icon({
        iconUrl: "img/Pin.png",

        iconSize: [42, 62], // size of the icon
        //shadowSize:   [50, 64], // size of the shadow
        iconAnchor: [21, 59], // point of the icon which will correspond to marker's location
        //shadowAnchor: [4, 62], // the same for the shadow
        //popupAnchor: [-3, -76], // point from which the popup should open relative to the iconAnchor
    });

    // Map initialization 
    var map = L.map('map', {
        minZoom: 14,
        maxZoom: 18,
    }).setView([51.5856651, 4.7922393], 20);

    //Markers toevoegen (met de aangemaakte variable cord)
    var markerAvans = L.marker([coordAvansB, coordAvansL], {
            icon: avansIcon
        })
        .addTo(map)
        .bindPopup("Avans Lovensdijkstraat");

    var markerQuestion;
    var questionCircles = [];
    <?php
    $getRouteId = $_SESSION["routeId"];

    foreach (getLocationCheck($getRouteId) as $questionMarker) {
        $i = 1;
        if (checkIfAnswered($questionMarker->questionId, $sessionTeamId) == true) {
    ?>
        var toPush<?php echo $i?> = new Array();
        toPush<?php echo $i?>[0] = <?php echo $questionMarker->questionId ?>;
        toPush<?php echo $i?>[1] = L.circle([<?php echo $questionMarker->longitude ?>, <?php echo $questionMarker->latitude ?>], {
                color: '#c7002b',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 40
            })
            .addTo(map)
            .bindPopup("Kom dichterbij om mij tezien!");
        questionCircles.push(toPush<?php echo $i?>);

    <?php $i++; 
        }
    }
    ?>

    //osm layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    if (!navigator.geolocation) {
        console.log("Your browser doesn't support geolocation feature!")
    } else {
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(getPosition)
        }, 5000);
    }

    var pointer, circle;

    function getPosition(position) {
        // console.log(position)
        var lat = position.coords.latitude
        var long = position.coords.longitude
        var accuracy = position.coords.accuracy
        var newLatLng = new L.LatLng(lat, long);
        if (pointer && circle) {
            pointer.setLatLng(newLatLng);
            circle.setLatLng(newLatLng)

        } else {
            pointer = L.marker([lat, long], {
                icon: avansPin
            })

            circle = L.circle([lat, long], {
                color: '#c7002b',
                fillColor: '#f03',
                fillOpacity: 0.5,
            }, {
                radius: accuracy
            })

            var featureGroup = L.featureGroup([pointer, circle]).addTo(map)
        }

        pointer.on("move", function(e) {
            questionCircles.forEach(function(circle) {
                var d = map.distance(e.latlng, circle[1].getLatLng());
                var isInside = d < circle[1].getRadius();
                circle[1].setStyle({
                    fillColor: isInside ? "green" : "#f03",
                    color: isInside ? "green" : "#f03"
                });
                if(isInside) {
                    circle[1].setPopupContent(`<a onclick='changeUrl(` + circle[0] + `)' type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal">` + 'Beantwoord vraag! ' + "</button>")
                    if(!circle[1].isPopupOpen()) {
                        circle[1].openPopup()
                    }
                } else {
                    circle[1].setPopupContent("Kom dichterbij om mij tezien!")
                }
            });
        });
    }

    <?php
    if (isset($_GET["questionId"])) { ?>
        $('#exampleModal').modal('show');
    <?php } ?>
</script>


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

    if ($questionType == 0) {
        checkAnswer($answer, $correctAnswer, $getQuestionId, $sessionTeamId);
    }
    echo "<script>"; ?>
    window.history.pushState("", "", './map.php');
    <?php echo "</script>";

    echo "<meta http-equiv='refresh' content='0'>";
} elseif (checkIfAnswered($questions->questionId, $sessionTeamId) == true) {

    echo "<script>";
    if (isset($_GET["questionId"])) { ?>
        $('#myModal').modal('show');
<?php }
    echo "</script>";
}
?>
?>