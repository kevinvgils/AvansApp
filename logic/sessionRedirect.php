

<?php
if (!$_SESSION['teamId']) {
    header("Location: index.php");
    exit();
}
