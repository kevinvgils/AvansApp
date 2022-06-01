<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/routeData.php");

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
    ?>
    <button type="button" onclick="window.location.href='http://localhost/AvansApp/addroute.php'">Nieuwe route toevoegen</button>
<?php
}
?>