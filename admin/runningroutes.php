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
    <link rel="stylesheet" href="../style/detail.css">
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/runningroutesheader.php"); ?>
    <main>
        <div class="wrap row">
            <?php
            foreach (getAllTeams() as $team) { ?>
                <div class="col-12 mb-3">
                    <div class="itemWrap">
                        <button type="button" class="collapsible"><?php echo $team->name; ?></button>
                        <div class="collapsible-content">
                            <p> Test </p>
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
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>
<!-- JS code -->