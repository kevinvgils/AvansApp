<?php
include("./dataaccess/databaseconnection.php");


$query = "SELECT * FROM `route`";
$stm = $con->prepare($query);
if ($stm->execute()) {
    $result = $stm->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $route) {
        echo $route->routeId;
        echo " ";
        echo $route->routeName;
        echo "<br/>";
        echo $route->description;
        echo "<br/>---------------------<br/>";
    }
}


?>
</br></br></br></br></br>
<form method="POST">
    <label>Route naam</label>
    <input name="txtRouteName" type="text" placeholder="Route naam..." required>
    </br>
    <label>Route descriptie</label>
    <input name="txtRouteDesc" type="text" placeholder="Route description..." required>
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
            <br /><input type="submit" name="btnOpslaan" value="Verstuur">

            <?php
            if (isset($_POST["btnOpslaan"])) {
                $routeName = $_POST["txtRouteName"];
                $course = $_POST["dropdowneducation"];
                $desc = $_POST["txtRouteDesc"];


                $query = "INSERT INTO `route`(`routeName`, `description`, `courseId`)" .
                    "VALUES ('$routeName', '$desc', '$course')";
                $stm = $con->prepare($query);
                $stm->execute();
            }
            ?>