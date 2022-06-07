function showSelected(elementValue) {
    const image = document.querySelectorAll(".image");
    const videoUrl = document.querySelectorAll(".videoUrl");

    if(elementValue.value == "none") {
        document.getElementById("videoUrl").value = null;
        document.getElementById("file").value = null;
        document.getElementById("videoUrl").required = false;
        document.getElementById("file").required = false;
        image.forEach(imageEl => {
            imageEl.style.display = 'none';
        });
        videoUrl.forEach(videoEl => {
            videoEl.style.display = 'none';
        });    
    } else if(elementValue.value == "image") {
        document.getElementById("videoUrl").value = null;
        document.getElementById("videoUrl").required = false;
        document.getElementById("file").required = true;
        image.forEach(imageEl => {
            imageEl.style.display = 'block';
        });
        videoUrl.forEach(videoEl => {
            videoEl.style.display = 'none';
        });
    } else if(elementValue.value == "videoUrl") {
        document.getElementById("file").value = null;
        document.getElementById("videoUrl").required = true;
        document.getElementById("file").required = false;
        image.forEach(imageEl => {
            imageEl.style.display = 'none';
        });
        videoUrl.forEach(videoEl => {
            videoEl.style.display = 'block';
        });
    }
}

function validateForm() {
    if(isFinite(document.getElementById("lat").value) && Math.abs(document.getElementById("lat").value) <= 90) {
        alert("Breedtegraad geen geldige waarde. Gebruik comma ipv punt!");
        return false;
    }

    if(isFinite(document.getElementById("long").value) && Math.abs(document.getElementById("long").value) <= 180) {
        alert("Lengtegraad geen geldige waarde. Gebruik comma ipv punt!");
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