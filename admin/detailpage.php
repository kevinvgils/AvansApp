<?php
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");
include("../dataaccess/questionData.php");
include("../dataaccess/coursedata.php");
include("../logic/editQuestion.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/detail.css">

    <!-- leaflet css  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

    <title>AvansApp | Admin</title>
</head>

<body>
    <?php include("templates/header.php"); ?>
    <main>
        <div class="wrap row detailWrap">
            <?php
            // variable id ophalen uit url
            $somevar = $_GET["id"];
            // query op routeid gebaseert op id uit url
            $query = "SELECT * FROM `route` WHERE `routeId` = :routeId";
            $stm = $con->prepare($query);
            $stm->bindValue(':routeId', $somevar);
            if ($stm->execute()) {
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                foreach ($result as $route) {
                    if (!$route->picture == null) {
                        $url = "data:image/jpeg;base64," . base64_encode($route->picture) ?>


                        <div class="col-12 col-md-4 img" style="background-image:url('<?php echo $url ?>')"></div>

                    <?php } ?>
                    <div class="details col-12 <?php if (!$route->picture == null) {
                            echo "col-md-8";
                        } ?>" style="<?php if (!$route->picture == null) {
                             echo "padding-left: 45px;";
                         } ?>">
                        <div class="header">
                            <h1 class="black"><?php echo $route->routeName ?></h1>
                            <?php foreach (getCourseById($route->courseId) as $course) { ?>
                                <p class="large"><?php echo $course->courseName; ?></p>
                            <?php } ?>
                        </div>
                        <div class="content">
                            <p><?php echo $route->description ?></p>
                            <!-- <p class="large">TODO: date</p> -->
                        </div>
                    </div>
                    <div class="col-12 questions">
                        <div class="header">
                            <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#myModal">
                                Voeg vraag toe
                            </button>
                            <p class="large">
                                Totaal: <?php echo count(getAllQuestionsForRoute($_GET['id'])); ?> vragen
                            </p>
                        </div>
                    </div>
            <?php }
            } ?>
            <?php
                $i = 1;
                foreach (getAllQuestionsForRoute($_GET['id']) as $question) { ?>
                    <div class="fullwidth questionDetail">
                        <div class="row">
                            <div class="col-9">
                                <h5 class="font-weight-bold">Vraag <?php echo $i . ": " . $question->question; $i++; ?></h5>
                                <h6 class="pt-1"><?php echo $question->description?>
                                <div class="pt-3">
                                    <?php foreach(getAllAnswersForQuestion($question->questionId) as $answer) {?>
                                        <p><?php echo ($answer->isCorrect == 1) ? $answer->answer . ' ✓' : $answer->answer; ?></p>
                                    <?php }?>
                               </div>
                            </div>
                            <div class="col-3">
                                <?php if (!empty($question->image)) {
                                    $url = "data:image/jpeg;base64," . base64_encode($question->image) ?>
                                    <div id="questionImage" style="background-image:url('<?php echo $url ?>')"></div>
                                <?php } else if(!empty($question->videoUrl)) { ?>
                                    <iframe id="questionVid"src="<?php echo $question->videoUrl ?>"></iframe> 
                                <?php } ?>
                            </div>
                        </div>
                        <div class="buttonWrap">
                            <a href="detailpage.php?edit=true&questionId=<?php echo $question->questionId; ?>&id=<?php echo $_GET["id"]; ?>" class="button">Bewerken</a>
                            <a href="../logic/deleteQuestion.php?id=<?php echo $question->questionId; ?>&routeId=<?php echo $_GET["id"]; ?>" class="button">Verwijderen</a>
                        </div>
                    </div>
            <?php } ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Voeg een vraag toe</h5>
                    <button type="button" class="close text-white" onclick="document.location.href='detailpage.php?id=<?php echo $somevar ?>'" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" >
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6 border-right mb-3">
                                    <label for="question" class="form-label">Titel</label>
                                    <input type="text" name="question" class="form-control mb-2" value="<?php echo getValueWhenEdit("question"); ?>" required>
                                    <label for="description" class="form-label" >Omschrijving</label>
                                    <textarea type="text" name="description" class="form-control mb-2" required><?php echo getValueWhenEdit("description"); ?></textarea>
                                    
                                    <label for="score" class="form-label">Aantal punten</label>
                                    <input type="number" name="score" class="form-control mb-2" min="1" value="<?php echo getValueWhenEdit("score"); ?>" required>
                                    
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input" id="latLong" <?php if(checkCoords()){ echo "checked";} ?> onchange="latLongChecked()">
                                        <label class="custom-control-label" for="latLong">Vraag met locatie?</label>
                                    </div>
                                    <div id="latLongDiv" class="row mb-2" <?php if(checkCoords()){ echo "style='display: flex;'"; } ?>>
                                            <!-- MAP -->
                                            <div id="map">
                                                <script>
                                                    //Avans coords
                                                    var coordAvansB = 51.5856651;
                                                    var coordAvansL = 4.7922393;

                                                    var avansIcon = L.icon({
                                                        iconUrl: "../img/LogoRed.png",

                                                        iconSize: [40, 30], // size of the icon
                                                        //shadowSize:   [50, 64], // size of the shadow
                                                        //iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                                                        //shadowAnchor: [4, 62], // the same for the shadow
                                                        //popupAnchor: [-3, -76], // point from which the popup should open relative to the iconAnchor
                                                    });

                                                    // Map initialization 
                                                    var map = L.map('map', {
                                                        minZoom: 13,
                                                        maxZoom: 16,
                                                    }).setView([51.5856651, 4.7922393], 13);

                                                    //Markers toevoegen (met de aangemaakte variable cord)
                                                    var markerAvans = L.marker([coordAvansB, coordAvansL], {
                                                            icon: avansIcon
                                                        })
                                                        .addTo(map)
                                                        .bindPopup("Avans startpunt");

                                                    //osm layer
                                                    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                                    });
                                                    osm.addTo(map);

                                                    //cords klik popup
                                                    var popup = L.popup();

                                                    function onMapClick(e) {
                                                        popup
                                                            .setLatLng(e.latlng)
                                                            .setContent("Coördinaat ingevuld!")
                                                            .openOn(map);

                                                        coordLat = e.latlng.lat;
                                                        coordLng = e.latlng.lng;


                                                        var longInput = $('#long');
                                                        var latInput = $('#lat');
                                                        longInput.val(coordLat);
                                                        latInput.val(coordLng);
                                                    }
                                                    map.on('click', onMapClick);
                                                </script>
                                            </div>
                                            <!-- MAP -->
                                        <div class="col-6">
                                            <label for="longtitude" class="form-label">Lengtegraad</label>
                                            <input type="text" id="long" name="longtitude" class="form-control" value="<?php echo getValueWhenEdit("longitude"); ?>">
                                        </div>
                                        <div class="col-6">
                                            <label for="latitude" class="form-label">Breedtegraad</label>
                                            <input type="text" id="lat" name="latitude" class="form-control" value="<?php echo getValueWhenEdit("latitude"); ?>">
                                        </div>
                                    </div>
                                    <label>Optionele afbeelding of video</label>
                                    <select class="mb-2 custom-select" onchange="showSelected(this)">
                                        <?php $toSelect = checkOptionalVidOrImg() ?>
                                        <option <?php if($toSelect == 0){ echo "selected"; } ?> value="none">---</option>
                                        <option <?php if($toSelect == 1){ echo "selected"; } ?> value="image">Afbeelding</option>
                                        <option <?php if($toSelect == 2){ echo "selected"; } ?> value="videoUrl">Youtube video</option>
                                    </select>
                                    
                                    <div id="videoUrlcontainer" <?php if($toSelect == 2){ echo "style='display: block;'"; } ?> class="mt-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3">www.youtube.com/watch?v=</span>
                                                </div>
                                                <input type="text" class="form-control" id="videoUrl" name="videoUrl" aria-describedby="basic-addon3">
                                            </div>
                                        </div>

                                    <label class="image" for="image" <?php if($toSelect == 1){ echo "style='display: block;'"; } ?>>Afbeelding</label>
                                    <input type="file" id="file" accept="image/*" class="form-control-file image" name="file" <?php if($toSelect == 1){ echo "style='display: block;'"; } ?>>
                                </div>
                                <div class="col-6 mb-3">
                                    <label>Vraag type</label>
                                    <select id="selectQuestionType" value="<?php echo $type; ?>" class="mb-2 custom-select" name="type" onchange="showMultipleChoiceFields(this)">
                                        <?php $type = getValueWhenEdit("questionType"); ?>
                                        <option <?php if($type == 0){ echo "selected"; } ?> value="0">Meerkeuzevraag</option>
                                        <option <?php if($type == 1){ echo "selected"; } ?> value="1">Openvraag</option>
                                        <option <?php if($type == 2){ echo "selected"; } ?> value="2">Afbeeldingsvraag</option>
                                    </select>
                                    <div id="multipleChoice" <?php if(getValueWhenEdit("questionType") != 0 && isEditing()){ echo "style='display: none;'";} ?>>
                                        <label>Aantal antwoord mogelijkheden</label>
                                        <?php $count = awnserCount() ?>
                                        <select id="awnserCount" value="<?php echo $count; ?>" class="mb-2 custom-select" onchange="showAnswerFields(this)">
                                            <option <?php if($count == 2){ echo "selected"; } ?> value="2">2</option>
                                            <option <?php if($count == 3){ echo "selected"; } ?> value="3">3</option>
                                            <option <?php if($count == 4){ echo "selected"; } ?> value="4">4</option>
                                        </select>
                                        <?php
                                            $questions = getQuestions();
                                        ?>
                                        <label for="answer1">Antwoord 1</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                <input type="checkbox" name="answer1CK" value="1" <?php if( isEditing() && isset($questions[0]) && $questions[0]->isCorrect == 1){ echo "checked";} ?> id="answer1CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                                </div>
                                            </div>
                                            <input type="text" id="answer1Txt" name="answer1" class="form-control" value="<?php if(isEditing() && $count >= 1){echo $questions[0]->answer;} ?>" aria-label="Text input with checkbox" required>
                                        </div>
                                        <label for="answer1">Antwoord 2</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                <input type="checkbox" name="answer2CK" value="1" <?php if(isEditing() && isset($questions[1]) && $questions[1]->isCorrect == 1){ echo "checked";} ?> id="answer2CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                                </div>
                                            </div>
                                            <input type="text" id="answer2Txt" name="answer2" class="form-control" value="<?php if(isEditing() && $count >= 2){echo $questions[1]->answer;} ?>" aria-label="Text input with checkbox" required>
                                        </div>
                                        <div id="answer3Div" <?php if(isEditing() && $count >= 3){ echo "style='display: block;'"; } ?>>
                                            <label for="answer1">Antwoord 3</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <input type="checkbox" name="answer3CK" value="1" <?php if( isEditing() && isset($questions[2]) && $questions[2]->isCorrect == 1){ echo "checked";} ?> id="answer3CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                                    </div>
                                                </div>
                                                <input type="text" id="answer3Txt" name="answer3" class="form-control" value="<?php if(isEditing() && $count >= 3){echo $questions[2]->answer;} ?>" aria-label="Text input with checkbox">
                                            </div>
                                        </div>
                                        <div id="answer4Div" <?php if(isEditing() && $count >= 4){ echo "style='display: block;'"; } ?>>
                                            <label for="answer1">Antwoord 4</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    <input type="checkbox" name="answer4CK" value="1" <?php if(isEditing() && isset($questions[3]) && $questions[3]->isCorrect == 1){ echo "checked";} ?> id="answer4CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                                    </div>
                                                </div>
                                                <input type="text" id="answer4Txt" name="answer4" class="form-control" value="<?php if(isEditing() && $count >= 4){echo $questions[3]->answer;} ?>" aria-label="Text input with checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="addQuestion" class="btn btn-danger">Opslaan</button>
                    </div>
                </form>
            </div>
    </main>
</body>
<!-- JS code -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="../js/detailpage.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<!--JS below-->


<!--modal-->
<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })


    $('#myModal').on('shown.bs.modal', function() {
        setTimeout(function() {
            map.invalidateSize();
        }, 10);
    });
</script>

<?php
    if (isset($_POST["addQuestion"])) {
        $routeId = $_GET["id"];
        $videoUrl = $_POST["videoUrl"];
        $questionType = $_POST["type"];
        $question = $_POST["question"];
        $description = $_POST["description"];
        $score = $_POST["score"];
        $latitude = $_POST["latitude"];
        $longtitude = $_POST["longtitude"];
        $image = null;
        if(!empty($_FILES['file']['tmp_name'])) {
            $image = addslashes(file_get_contents($_FILES['file']['tmp_name']));
        }

        if($_POST["videoUrl"] != "") {
            $videoUrl = "https://www.youtube.com/embed/" . $videoUrl;
        }
        
        $allAnswers = array (
            array(1, $_POST["answer1"], (isset($_POST["answer1CK"])) ? $_POST["answer1CK"] : NULL),
            array(2, $_POST["answer2"], (isset($_POST["answer2CK"])) ? $_POST["answer2CK"] : NULL),
            array(3, $_POST["answer3"], (isset($_POST["answer3CK"])) ? $_POST["answer3CK"] : NULL),
            array(4, $_POST["answer4"], (isset($_POST["answer4CK"])) ? $_POST["answer4CK"] : NULL)
        );

        if(!isEditing()){
            addQuestionToRoute($routeId, $questionType, $question, $description, $score, $latitude, $longtitude, $image, $videoUrl, $allAnswers);
        } else{
            updateQuestionToRoute($_GET["questionId"], $routeId, $questionType, $question, $description, $score, $latitude, $longtitude, $image, $videoUrl, $allAnswers);
        }?> 
        <script>
            window.location.replace("detailpage.php?id=<?php echo $routeId; ?>");
        </script>
    <?php } ?>

<script>
    <?php
    if (isEditing()) { ?>
        $('#myModal').modal('show');
    <?php } ?>

    $('#myModal').on('hidden.bs.modal', function (e) {
     $(this)
        .find("input,textarea")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();
    })
</script>
</html>