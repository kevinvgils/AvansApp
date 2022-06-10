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
                        <button type="button" class="collapsible itemHeader">
                            <img src="../img/down-arrow.png" alt="Down Arrow" width="30" height="30">
                            <h3 class="collapsible-text"><?php echo $team->name; ?></h3>
                        </button>
                        <div class="collapsible-content">
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tincidunt nisi sed ante condimentum venenatis. Phasellus eu enim nec dolor sodales fringilla quis a nisi. Cras eu sapien feugiat, lobortis enim eget, placerat mauris. Vivamus elit est, semper tristique est at, dapibus consectetur mi. Sed eleifend dolor eu metus sodales bibendum. Mauris aliquam lectus id est sagittis rutrum. Morbi ut dolor condimentum, interdum sem in, ultrices nunc. Proin sapien ipsum, pulvinar ut odio eget, rutrum egestas diam. Suspendisse ac est aliquet libero volutpat malesuada. Aenean sed nibh blandit, volutpat dolor et, pulvinar metus. Etiam vulputate, est euismod posuere blandit, tellus neque vestibulum purus, quis eleifend mauris metus eget libero. Fusce eget nisl posuere, malesuada enim sed, pulvinar odio. Mauris quis nisl at nunc sagittis varius non at arcu. Etiam tincidunt elit et felis cursus hendrerit. Pellentesque non condimentum ipsum, elementum fermentum massa. Fusce id ante ac tellus imperdiet dictum at a elit. </p>
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