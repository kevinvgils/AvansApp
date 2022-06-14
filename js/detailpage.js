function showSelected(elementValue) {
    const image = document.querySelectorAll(".image");
    const videoUrl = document.querySelectorAll(".videoUrl");

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


    if(isFinite(latReplaced) && Math.abs(latReplaced) <= 90 && hasLocation) {
        alert("Breedtegraad geen geldige waarde.");
        return false;
    }

    if(isFinite(long) && Math.abs(longReplaced) <= 180 && hasLocation) {
        alert("Lengtegraad geen geldige waarde.");
        return false;
    }

    if(!answerCK1 && !answerCK2 && !answerCK3 && !answerCK4) {
        alert("Selecteer een correct antwoord!");
        return false;
    }


}

function latLongChecked() {
    if(document.getElementById("latLong").checked) {
        document.getElementById("latLongDiv").style.display = 'flex';
        document.getElementById("lat").required = true;
        document.getElementById("long").required = true;
    } else {
        document.getElementById("latLongDiv").style.display = 'none';
        document.getElementById("lat").value = null;
        document.getElementById("long").value = null;
    };
}

function selectOnlyThis(id) {
    for (let i = 1;i <= 4; i++) {
        document.getElementById("answer" + i + "CK").checked = false;
    }
    document.getElementById(id).checked = true;
}