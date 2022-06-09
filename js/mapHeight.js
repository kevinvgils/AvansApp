const mapElement = document.getElementById('map');
function resize() {
  let headerHight = document.getElementsByTagName("header")[0].offsetHeight;
  mapElement.style.height = (screen.height - headerHight) + "px";
  
}

resize();
window.addEventListener('resize', resize);

