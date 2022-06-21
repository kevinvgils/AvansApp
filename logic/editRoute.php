<?php
function isEditing(){
  if(isset($_GET["edit"]) && $_GET["edit"] == true){
    return true;
  } else{
    return false;
  }
}

function getValueWhenEdit($valueKey){
  if(isEditing()){
    $route = getRouteById($_GET["id"])[0];
    return $route->$valueKey;
  } else{
    return "";
  }
}

function checkCourse($routeCourseId, $courseId){
  if(isEditing() && $routeCourseId == $courseId){
    return true;
  } else{
    return false;
  }
}
?>