<?php
include("databaseconnection.php");


$query = "SELECT * FROM `route`";
$stm = $con->prepare($query);
if ($stm->execute()) {
    $result = $stm->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $route) {
?>
        <a href="http://localhost/AvansApp/detailpage.php?id=<?php echo $route->routeId; ?>">
            <?php
            echo $route->routeId;
            echo " ";
            echo $route->routeName;
            echo "<br/>";
            echo $route->description;
            echo "<img src='data:image/jpeg;base64, " . base64_encode($route->picture) . "' alt='No film found' class='card-image'>";
            echo "<br/>---------------------<br/>";

            ?>
        </a>
<?php
    }
}


?>
</br></br></br></br></br>
<form method="POST" enctype="multipart/form-data">
    <label>Route naam</label>
    <input name="txtRouteName" type="text" placeholder="Route naam..." required>
    </br>
    <label>Route descriptie</label>
    <!--<input name="txtRouteDesc" type="text" placeholder="Route description..." required>-->
    <textarea id="txtRouteDesc" name="txtRouteDesc" rows="4" cols="50"></textarea>

    </br>
    <label>Route opleiding</label>
    <select name="dropdowneducation">
        <?php
        $query2 = "SELECT * FROM `course`";
        $stm = $con->prepare($query2);
        if ($stm->execute()) {
            $result2 = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result2 as $course) {
                echo '<option value=" ' . $course->courseId . ' "> ' . $course->courseName . ' </option>';
            }
        }
        ?>

        <select>
            <input type="file" class="form-control-file" id="picture" name="picture">
            <br /><input type="submit" name="btnOpslaan" value="Verstuur">

            <?php
            if (isset($_POST["btnOpslaan"])) {
                $routeName = $_POST["txtRouteName"];
                $course = $_POST["dropdowneducation"];
                $desc = $_POST["txtRouteDesc"];
                $picture = addslashes(file_get_contents($_FILES['picture']['tmp_name']));


                $query = "INSERT INTO `route`(`routeName`, `description`, `courseId`, `picture`)" .
                    "VALUES ('$routeName', '$desc', '$course', '$picture')";
                $stm = $con->prepare($query);
                $stm->execute();
            }
            ?>