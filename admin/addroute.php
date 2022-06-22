<?php
include("../dataaccess/databaseconnection.php");
include("../dataaccess/routeData.php");
include("../dataaccess/courseData.php");
include("../logic/adminRedirect.php");
include("../logic/editRoute.php");

if (isset($_POST["btnOpslaan"])) {
    $routeName = $_POST["txtRouteName"];
    $course = $_POST["dropdowneducation"];
    $desc = $_POST["txtRouteDesc"];

    if($_FILES['picture']['tmp_name'] == null){
        $picture = null;
    } else {
        $picture = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
    }
    
    if(isEditing()){
        updateRoute($_GET["id"], $routeName, $course, $desc, $picture);
    } else {
        addRoutes($routeName, $course, $desc, $picture);
    }
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/addRoute.css">
    <title>AvansApp</title>
</head>

<body>
    <?php include("templates/header.php"); ?>
    <main>
        <div class="wrap">

            <div class="item">
                <div class="itemWrap">
                    <div class="itemHeader">
                        <h3>Route <?php if(isEditing()){
                            echo 'aanpassen';
                        } else{
                            echo 'aanmaken';
                        } ?></h3>
                    </div>
                    <div class="itemContent">
                        <form method="POST" class="addRouteForm" enctype="multipart/form-data">
                            <label>Route naam</label>
                            <input value="<?php echo getValueWhenEdit("routeName"); ?>" name="txtRouteName" type="text" placeholder="Route naam..." required>

                            <label>Route descriptie</label>
                            <textarea id="txtRouteDesc" name="txtRouteDesc" rows="4" cols="50"><?php echo getValueWhenEdit("description"); ?></textarea>

                            <label>Route opleiding</label>
                            <select name="dropdowneducation">
                                <?php
                                $SelectedId = getValueWhenEdit("courseId");
                                var_dump($SelectedId);
                                foreach (getCourses() as $course) { ?>
                                    <option <?php if(checkCourse($SelectedId, $course->courseId)){ echo "selected";} ?> value="<?php echo $course->courseId; ?>"><?php echo $course->courseName; ?></option>';
                                <?php } ?>
                            </select>
                            <label>Route afbeelding</label>
                            <input type="file" accept="image/*" class="form-control-file" id="picture" name="picture">
                            <input type="submit" name="btnOpslaan" value="Route opslaan" class="button buttonWrap">
                        </form>
                    </div>

                </div>
            </div>


        </div>
    </main>
</body>

</html>