<?php
include("databaseconnection.php");


$query = "SELECT * FROM `routeName`";
$stm = $con->prepare($query);
if ($stm->execute()) {
    $result = $stm->fetchAll(PDO::FETCH_OBJ);
    foreach ($result as $route) {
        echo $route->id;
        echo " ";
        echo $route->routeName;
        echo $route->education;
        echo "<br/>";
    }
}


?>
</br></br></br></br></br>
<form method="POST">
    <label>Route naam</label>
    <input name="txtRouteName" type="text" placeholder="Route naam..." required>
    </br>
    <label>Route opleiding</label>
    <select name="dropdowneducation">
        <?php
        $query2 = "SELECT * FROM ` educations`";
        $stm = $con->prepare($query2);
        if ($stm->execute()) {
            $result2 = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach ($result2 as $educations) {
                echo '<option value=" ' . $educations->name . ' "> ' . $educations->name . ' </option>';
            }
        }
        ?>

        <select>
            <br /><input type="submit" name="btnOpslaan" value="Verstuur">

            <?php
            if (isset($_POST["btnOpslaan"])) {
                $routeName = $_POST["txtRouteName"];
                $education = $_POST["dropdowneducation"];

                $query = "INSERT INTO `routename`(`routeName`, `education`)" .
                    "VALUES ('$routeName','$education')";
                $stm = $con->prepare($query);
                $stm->execute();
            }
            ?>