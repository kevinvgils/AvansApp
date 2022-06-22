<?php 
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");
include("../dataaccess/courseData.php");

if (isset($_POST["inloggen"])) {
    $userName = $_POST["username"];
    $password = $_POST["passwword"];
    if(hash('md5', $password) == '098f6bcd4621d373cade4e832627b4f6' && $userName == "admin"){  //test

      session_start();
      $_SESSION['isLoggedIn'] = true;

      header("Location: index.php");
      exit();
    } else{
      $_GET['error'] = "Gebruikersgegevens komen niet overheen";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/addRoute.css">
    <title>AvansApp | Admin</title>
</head>
<body>
    <?php include("templates/header.php"); ?>
    <main>
        <div class="wrap">

        <div class="item">
            <div class="itemWrap">
              <div class="itemHeader">
                  <h3>Route aanmaken</h3>
              </div>
              <div class="itemContent">
                <form method="POST" class="addRouteForm" enctype="multipart/form-data">
                    <?php if(isset($_GET['error'])){ ?><label class="error"><?php echo $_GET['error']; ?></label><?php } ?>
                    <label>Gebruikersnaam</label>
                    <input name="username" type="text" placeholder="Gebruikersnaam..." required>
                    <label>Wachtwoord</label>
                    <input name="passwword" type="password" placeholder="Wachtwoord..." required>
                    <input type="submit" name="inloggen" value="Inloggen" class="button buttonWrap">
                </form>
              </div>
            </div>
          </div>
        </div>
    </main>
</body>
</html>