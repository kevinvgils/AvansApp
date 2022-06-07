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
    const long = document.getElementById("long").value
    const longReplaced = long.replaceAll('.', ',');
    const lat = document.getElementById("lat").value
    const latReplaced = lat.replaceAll('.', ',');

    if(isFinite(latReplaced) && Math.abs(latReplaced) <= 90) {
        alert("Breedtegraad geen geldige waarde.");
        return false;
    }

    if(isFinite(long) && Math.abs(longReplaced) <= 180) {
        alert("Lengtegraad geen geldige waarde.");
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