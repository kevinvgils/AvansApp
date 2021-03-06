function showSelected(elementValue) {
    const image = document.querySelectorAll(".image");

    if(elementValue.value == "none") {
        document.getElementById("videoUrl").value = null;
        document.getElementById("file").value = null;
        document.getElementById("videoUrl").required = false;
        document.getElementById("file").required = false;
        document.getElementById("videoUrlcontainer").style.display = "none";
        image.forEach(imageEl => {
            imageEl.style.display = 'none';
        });  
    } else if(elementValue.value == "image") {
        document.getElementById("videoUrl").value = null;
        document.getElementById("videoUrl").required = false;
        document.getElementById("file").required = true;
        document.getElementById("videoUrlcontainer").style.display = "none";
        image.forEach(imageEl => {
            imageEl.style.display = 'block';
        });
    } else if(elementValue.value == "videoUrl") {
        document.getElementById("file").value = null;
        document.getElementById("videoUrl").required = true;
        document.getElementById("file").required = false;
        document.getElementById("videoUrlcontainer").style.display = "flex";
        image.forEach(imageEl => {
            imageEl.style.display = 'none';
        });
    }
}

function showMultipleChoiceFields(type){
    if(type.value != 0){
        document.getElementById("multipleChoice").style.display = "none";
        document.getElementById("answer1Txt").required = false;
        document.getElementById("answer2Txt").required = false;
        document.getElementById("answer3Txt").required = false;
        document.getElementById("answer4Txt").required = false;
    } else{
        const count = document.getElementById("awnserCount").value;
        document.getElementById("multipleChoice").style.display = "block";
        if(count >= 2){
            document.getElementById("answer1Txt").required = true;
            document.getElementById("answer2Txt").required = true;
        }
        if(count >= 3){
            document.getElementById("answer3Txt").required = true;
        }
        if(count >= 4){
            document.getElementById("answer4Txt").required = true;
        }
    }
}

function showAnswerFields(elementValue) {
    if(elementValue.value == "2") {
        document.getElementById("answer3CK").checked = false
        document.getElementById("answer3Div").style.display = "none"
        document.getElementById("answer3Txt").required = false
        document.getElementById("answer4Div").style.display = "none"
        document.getElementById("answer4Txt").required = false
        document.getElementById("answer4CK").checked = false
    } else if(elementValue.value == "3") {
        document.getElementById("answer3Div").style.display = "block"
        document.getElementById("answer3Txt").required = true
        document.getElementById("answer4Div").style.display = "none"
        document.getElementById("answer4Txt").required = false
        document.getElementById("answer4CK").checked = false
    } else if(elementValue.value == "4") {
        document.getElementById("answer3Div").style.display = "block"
        document.getElementById("answer3Txt").required = true
        document.getElementById("answer4Div").style.display = "block"
        document.getElementById("answer4Txt").required = true
    }
}

function validateForm() {
    const long = document.getElementById("long").value
    const longReplaced = long.replaceAll('.', ',');
    const lat = document.getElementById("lat").value
    const latReplaced = lat.replaceAll('.', ',');
    const hasLocation = document.getElementById("latLong").checked
    const answerCK1 = document.getElementById("answer1CK").checked
    const answerCK2 = document.getElementById("answer2CK").checked
    const answerCK3 = document.getElementById("answer3CK").checked
    const answerCK4 = document.getElementById("answer4CK").checked
    const multipleChoice = document.getElementById("multipleChoice").style.display;

    if(isFinite(latReplaced) && Math.abs(latReplaced) <= 90 && hasLocation) {
        alert("Breedtegraad geen geldige waarde.");
        return false;
    }

    if(isFinite(long) && Math.abs(longReplaced) <= 180 && hasLocation) {
        alert("Lengtegraad geen geldige waarde.");
        return false;
    }

    if(document.getElementById("selectQuestionType").value == 0 && !answerCK1 && !answerCK2 && !answerCK3 && !answerCK4) {
        alert("Selecteer een correct antwoord!");
        return false;
    }


}

function latLongChecked() {
    if(document.getElementById("latLong").checked) {
        document.getElementById("latLongDiv").style.display = 'flex';
        document.getElementById("lat").required = true;
        document.getElementById("long").required = true;

        setTimeout(function() {
            map.invalidateSize();
        }, 10);
        
    } else {
        document.getElementById("latLongDiv").style.display = 'none';
        document.getElementById("lat").value = null;
        document.getElementById("long").value = null;
        document.getElementById("lat").required = false;
        document.getElementById("long").required = false;
    };
}

function selectOnlyThis(id) {
    for (let i = 1;i <= 4; i++) {
        document.getElementById("answer" + i + "CK").checked = false;
    }
    document.getElementById(id).checked = true;
}

var element = document.getElementById('selectQuestionType');
var event = new Event('change');
element.dispatchEvent(event);

var element = document.getElementById('awnserCount');
var event = new Event('change');
element.dispatchEvent(event);