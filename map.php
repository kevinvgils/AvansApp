<?php
include("./dataaccess/databaseconnection.php");
include("./dataaccess/questionData.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/map.css">
    <title>AvansApp</title>

    <!-- leaflet css  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

</head>

<body>
    <?php include("templates/mapheader.php");
    session_start();
    ?>
    <div id="map"></div>


</body>

</html>

<!-- leaflet js  -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    //Test cords
    var coordAvansB = 51.5856651;
    var coordAvansL = 4.7922393;

    // var coordChasseB = 51.5891643;
    // var coordChasseL = 4.7860003;

    // var coordCasinoB = 	51.5874996;
    // var coordCasinoL = 4.7810686;

    // var coordKoepelB = 	51.5902832;
    // var coordKoepelL = 4.7872995094107;

    // var coordHogeschoollaanB = 	51.58516;
    // var coordHogeschoollaanL = 4.797319;



    var avansIcon = L.icon({
        iconUrl: "img/LogoRed.png",

        iconSize: [60, 50], // size of the icon
        //shadowSize:   [50, 64], // size of the shadow
        //iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
        //shadowAnchor: [4, 62], // the same for the shadow
        //popupAnchor: [-3, -76], // point from which the popup should open relative to the iconAnchor
    });

    var avansPin = L.icon({
        iconUrl: "img/Pin.png",

        iconSize: [42, 62], // size of the icon
        //shadowSize:   [50, 64], // size of the shadow
        iconAnchor: [21, 59], // point of the icon which will correspond to marker's location
        //shadowAnchor: [4, 62], // the same for the shadow
        //popupAnchor: [-3, -76], // point from which the popup should open relative to the iconAnchor
    });

    // Map initialization 
    var map = L.map('map', {
        minZoom: 14,
        maxZoom: 18,
    }).setView([51.5856651, 4.7922393], 20);

    //Markers toevoegen (met de aangemaakte variable cord)
    var markerAvans = L.marker([coordAvansB, coordAvansL], {
            icon: avansIcon
        })
        .addTo(map)
        .bindPopup("Avans Lovensdijkstraat");

    // var markerChasse = L.marker([coordChasseB, coordChasseL], { icon: avansPin })
    // .addTo(map)
    // .bindPopup("Hier kan dan een vraag komen.");

    // var markerCasino = L.marker([coordCasinoB, coordCasinoL], { icon: avansPin })
    // .addTo(map)
    // .bindPopup("Hier kan dan een vraag komen.");

    // var markerKoepel = L.marker([coordKoepelB, coordKoepelL], { icon: avansPin })
    // .addTo(map)
    // .bindPopup("Hier kan dan een vraag komen.");

    // var markerHogeschoollaan = L.marker([coordHogeschoollaanB, coordHogeschoollaanL], { icon: avansPin })
    // .addTo(map).on('click', onClick);

    var markerQuestion
    <?php
    $getRouteId = $_SESSION["routeId"];

    foreach (getLocationCheck($getRouteId) as $questionMarker) {
    ?>

        var markerChasse = L.marker([<?php echo $questionMarker->longitude ?>, <?php echo $questionMarker->latitude ?>], {
                icon: avansPin
            })
            .addTo(map)
            .bindPopup("Kom dichterbij om mij tezien!");

    <?php }
    ?>

    //osm layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    if (!navigator.geolocation) {
        console.log("Your browser doesn't support geolocation feature!")
    } else {
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(getPosition)
        }, 5000);
    }

    var pointer, circle;

    function getPosition(position) {
        // console.log(position)
        var lat = position.coords.latitude
        var long = position.coords.longitude
        var accuracy = position.coords.accuracy

        if (pointer) {
            map.removeLayer(pointer)
        }

        if (circle) {
            map.removeLayer(circle)
        }

        pointer = L.marker([lat, long], {
            icon: avansPin
        })

        circle = L.circle([lat, long], {
            color: '#c7002b',
            fillColor: '#f03',
            fillOpacity: 0.5,
        }, {
            radius: accuracy
        })

        var featureGroup = L.featureGroup([pointer, circle]).addTo(map)

        //Centreert opnieuw wanneer de locatie verandert
        //map.fitBounds(featureGroup.getBounds())

        console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)
    }

    //--------
    // bietje kutten met radius
    // function onClick(e) {
    //     const cords = this.getLatLng();
    //     const cordLat = cords.lat;
    //     const cordLong = cords.lng;
    //     //const result2 =


    //     console.log(cords);
    //     console.log(cordLat);
    //     console.log(cordLong);
    // }
    //---------
    //cords klik popup

    // var popup = L.popup();

    // function onMapClick(e) {
    //     popup
    //         .setLatLng(e.latlng)
    //         .setContent("You clicked the map at " + e.latlng.toString())
    //         .openOn(map);
    // }

    // map.on('click', onMapClick);
</script>