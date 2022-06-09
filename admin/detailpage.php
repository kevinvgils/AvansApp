<?php
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");
include("../dataaccess/questionData.php");
include("../dataaccess/coursedata.php")

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/detail.css">
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/header.php"); ?>
    <main>
        <div class="wrap row detailWrap">
            <?php
            include("../dataaccess/databaseconnection.php");
            // variable id ophalen uit url
            $somevar = $_GET["id"];
            // query op routeid gebaseert op id uit url
            $query = "SELECT * FROM `route` WHERE `routeId` = " . $somevar;
            $stm = $con->prepare($query);
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
                        <div class="header row">
                            <button type="button" class="btn btn-danger btn-sm mb-1 col-2" data-toggle="modal" data-target="#myModal">
                                Voeg vraag toe
                            </button>
                            <p class="large col-10">
                                Totaal: <?php echo count(getAllQuestionsForRoute($_GET['id'])); ?> vragen
                            </p>
                        </div>
                    </div>
            <?php }
            } ?>
            <?php
                $i = 1;
                foreach (getAllQuestionsForRoute($_GET['id']) as $question) { ?>
                    <div class="fullwidth" style="border-bottom: solid black 1px; margin-bottom: 20px; padding-bottom: 20px;">
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
                    </div>
            <?php } ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Voeg een vraag toe</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" >
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-6 border-right mb-3">
                                    <label for="question" class="form-label">Titel</label>
                                    <input type="text" name="question" class="form-control mb-2" required>
                                    <label for="description" class="form-label" >Omschrijving</label>
                                    <textarea type="text" name="description" class="form-control mb-2" required></textarea>
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input" id="latLong" onchange="latLongChecked()">
                                        <label class="custom-control-label" for="latLong">Vraag met locatie?</label>
                                    </div>
                                    <div id="latLongDiv" class="row mb-2">
                                        <div class="col-6">
                                            <label for="latitude" class="form-label">Breedtegraad</label>
                                            <input type="text" id="lat" name="latitude" class="form-control">
                                        </div>
                                        <div class="col-6">
                                            <label for="longtitude" class="form-label">Lengtegraad</label>
                                            <input type="text" id="long" name="longtitude" class="form-control">
                                        </div>
                                    </div>
                                    <label>Optionele afbeelding of video</label>
                                    <select class="mb-2 custom-select" onchange="showSelected(this)">
                                        <option selected value="none">---</option>
                                        <option value="image">Afbeelding</option>
                                        <option value="videoUrl">Youtube video</option>
                                    </select>
                                    <label class="videoUrl" for="videoUrl">Youtube video URL</label>
                                    <input type="text" id="videoUrl" class="form-control mb-2 videoUrl" name="videoUrl">
                                    <label class="image" for="image">Afbeelding</label>
                                    <input type="file" id="file" accept="image/*" class="form-control-file image" name="file">
                                </div>
                                <div class="col-6 mb-3">
                                <label>Aantal antwoord mogelijkheden</label>
                                    <select class="mb-2 custom-select" onchange="showAnswerFields(this)">
                                        <option selected value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                    <label for="answer1">Antwoord 1</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox" name="answer1CK" value="1" id="answer1CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                            </div>
                                        </div>
                                        <input type="text" id="answer1Txt" name="answer1" class="form-control" aria-label="Text input with checkbox" required>
                                    </div>
                                    <label for="answer1">Antwoord 2</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox" name="answer2CK" value="1" id="answer2CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                            </div>
                                        </div>
                                        <input type="text" id="answer2Txt" name="answer2" class="form-control" aria-label="Text input with checkbox" required>
                                    </div>
                                    <div id="answer3Div">
                                        <label for="answer1">Antwoord 3</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                <input type="checkbox" name="answer3CK" value="1" id="answer3CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                                </div>
                                            </div>
                                            <input type="text" id="answer3Txt" name="answer3" class="form-control" aria-label="Text input with checkbox">
                                        </div>
                                    </div>
                                    <div id="answer4Div">
                                        <label for="answer1">Antwoord 4</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                <input type="checkbox" name="answer4CK" value="1" id="answer4CK" aria-label="Checkbox for following answer to check if correct" onclick="selectOnlyThis(this.id)">
                                                </div>
                                            </div>
                                            <input type="text" id="answer4Txt" name="answer4" class="form-control" aria-label="Text input with checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="addQuestion" class="btn btn-danger">Submit</button>
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
</script>
<?php
    if (isset($_POST["addQuestion"])) {
        $routeId = $_GET["id"];
        $question = $_POST["question"];
        $description = $_POST["description"];
        $latitude = $_POST["latitude"];
        $longtitude = $_POST["longtitude"];
        $image = null;
        if(!empty($_FILES['file']['tmp_name'])) {
            $image = addslashes(file_get_contents($_FILES['file']['tmp_name']));
        }
        $videoUrl = $_POST["videoUrl"];
        $allAnswers = array (
            array(1, $_POST["answer1"], (isset($_POST["answer1CK"])) ? $_POST["answer1CK"] : NULL),
            array(2, $_POST["answer2"], (isset($_POST["answer2CK"])) ? $_POST["answer2CK"] : NULL),
            array(3, $_POST["answer3"], (isset($_POST["answer3CK"])) ? $_POST["answer3CK"] : NULL),
            array(4, $_POST["answer4"], (isset($_POST["answer4CK"])) ? $_POST["answer4CK"] : NULL)
        );
        addQuestionToRoute($routeId, $question, $description, $latitude, $longtitude, $image, $videoUrl, $allAnswers);

    //sorry voor deze oplossing als je een betere oplossing weet laat het dan weten :)
    echo "<meta http-equiv='refresh' content='0'>";
    exit();
}
?>