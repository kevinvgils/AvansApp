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
    $question = getQuestionDetails($_GET["questionId"], $_GET["id"])[0];
    return $question->$valueKey;
  } else{
    return "";
  }
}

function checkCoords(){
  if(isEditing()){
    $question = getQuestionDetails($_GET["questionId"], $_GET["id"])[0];
    if($question->longitude != null && $question->latitude != null){
      return true;
    } else{
      return false;
    }
  } else{
    return false;
  }
}

function awnserCount(){
  if(isEditing()){
    $question = getAwnserCount($_GET["questionId"])[0];
    return $question->count;
  } else{
    return 2;
  }
}

function getQuestions(){
  if(isEditing()){
    return getAllAnswersForQuestion($_GET['questionId']);
  } else{
    return "";
  }
}

function checkOptionalVidOrImg(){
  if(isEditing()){
    $question = getQuestionDetails($_GET["questionId"], $_GET["id"])[0];
    if($question->image != null){
      return 1;
    } else if($question->videoUrl != null){
      return 2;
    } else{
      return 0;
    }
  }
  else{
    return 0;
  }
}

?>