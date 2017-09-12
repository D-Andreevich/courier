function initMap() {
    var latlng = new google.maps.LatLng(49.9935, 36.230383);
    var mapOptions = {
        zoom: 13,
        center: latlng,
        minZoom: 12,
        maxZoom: 18,
        mapTypeControl: false,

    };
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latlng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(latlng);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Я тута!'
            });
        });
    }

    google.maps.event.addListenerOnce(map, 'tilesloaded', function(){
        readMarkers(map);
    });
}

function readMarkers(map){
    var markers = document.getElementsByTagName('marker');
    var i=0;
    /*var marker=[];
    var infowindow=[];*/
    Array.prototype.forEach.call(markers, function(markerElem) {

        var address = markerElem.getAttribute('address');
        var distance = markerElem.getAttribute('distance');
        var point ={lat: Number(markerElem.getAttribute('lat')),
            lng: Number(markerElem.getAttribute('lng')) };

        setTimeout(function() {
            i++;
            var marker = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                position: point,
                map: map
            });
            var contentString = 'start='+i;
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 400
            });
            console.log(i);
        },i * 1500);

    });
    console.log(markerElem);
    console.log(marker);


}
