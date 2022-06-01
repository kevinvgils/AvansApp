<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/routeData.php");
?>
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
            <br />
            <a href="http://localhost/AvansApp/overzicht.php">
                <input type="submit" name="btnOpslaan" value="Verstuur">
            </a>
            <?php
            if (isset($_POST["btnOpslaan"])) {
                $routeName = $_POST["txtRouteName"];
                $course = $_POST["dropdowneducation"];
                $desc = $_POST["txtRouteDesc"];
                $picture = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
                addRoutes($routeName, $course, $desc, $picture);

                //sorry voor deze oplossing als je een betere oplossing weet laat het dan weten :)
                header("Location: overzicht.php");
                exit();
            }
            ?>