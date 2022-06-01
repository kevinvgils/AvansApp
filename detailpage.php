<?php 
include("./dataaccess/databaseconnection.php");
include("./dataaccess/routeData.php");
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
                                <?php echo count(getAllQuestionsForRoute($_GET['id'])); ?> vragen
                            </p>
                            <button type="button" onclick="on()" class="btn btn-danger">Voeg vraag toe</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Launch demo modal
                            </button>
                        </div>
                    </div>
            <?php }} ?>
            <?php
                $i = 1;
                foreach (getAllQuestionsForRoute($_GET['id']) as $question) { ?>
                    <div class="container" style="border-bottom: solid black 1px; margin-bottom: 20px; padding-bottom: 20px;">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="font-weight-bold">Vraag <?php echo $i . ": " . $question->question; $i++; ?></h5>
                                <p>A:</p>
                                <p>B:</p>
                                <p>C:</p>
                                <p>D:</p>
                            </div>
                        </div>
                    </div>
            <?php }?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Voeg een vraag toe</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Vraag</label>
                            <input type="text" name="question" class="form-control">
                        </div>
                        <div class="mb-3">
                            TODO: VOEG ANTWOORDEN TOE BIJ VRAAG
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addQuestion" class="btn btn-danger">Submit</button>
                </div>
                </div>
            </div>
        </div>

        <div id="overlayContainer">
            <div id="overlayDiv">
                <div class="card">
                    <div class="card-header container-fluid bg-danger text-white border-danger">
                        <div class="row">
                            <p class="col-11">Voeg vraag toe</p>
                            <button type="button" class="btn btn-danger btn-sm">close</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Vraag</label>
                                <input type="text" name="question" class="form-control">
                            </div>
                            <div class="mb-3">
                                TODO: VOEG ANTWOORDEN TOE BIJ VRAAG
                            </div>
                            <button type="submit" name="addQuestion" class="btn btn-danger">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<!-- JS code -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js">
</script>
<!--JS below-->


<!--modal-->
<script>
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
</script>
<script>
    function on() {
  document.getElementById("overlayContainer").style.display = "flex";
}

function off() {
  document.getElementById("overlayContainer").style.display = "none";
}
</script>
<?php
    if (isset($_POST["addQuestion"])) {
        $routeId = $_GET["id"];
        $question = $_POST["question"];
        addQuestionToRoute($routeId, $question);

        //sorry voor deze oplossing als je een betere oplossing weet laat het dan weten :)
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }
?>
