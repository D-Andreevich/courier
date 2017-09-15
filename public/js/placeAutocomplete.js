/**
 * Created by D-Andreevich on 14.09.2017.
 */
var marker1, marker2;
var map, geocoder, autocomplete, directionsDisplay, directionsService;
var address_a = 'address_a';
var address_b = 'address_b';


function addMap() {
    var latlng = new google.maps.LatLng(49.9935, 36.230383);
    var mapOptions = {
        zoom: 13,
        center: latlng,
        // minZoom: 12,
        maxZoom: 18,
        mapTypeControl: false,
        streetViewControl: false
    };
    map = new google.maps.Map(document.getElementById('addMap'),mapOptions);

    geocoder = new google.maps.Geocoder;

    directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers : true // не использовать маркеры
    });
    directionsService = new google.maps.DirectionsService;
    directionsDisplay.setMap(map);

    marker1 = new google.maps.Marker({
        map: map,
        icon : 'https://developers.google.com/maps/documentation/javascript/images/marker_greenA.png',
        draggable: true,
        // label: 'A',
        position: {lat: 49.9942, lng: 36.230391}
    });

    marker2 = new google.maps.Marker({
        map: map,
        label: 'B',
        draggable: true,
        position: {lat: 49.97930368719336, lng: 36.24643119685061}
    });

    google.maps.event.addListener(marker1, 'mouseup', function(){ update('marker1')});
    google.maps.event.addListener(marker2, 'mouseup', function(){ update('marker2')});

    update('all');
}

function myPosition(id){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(pos);
            map.setZoom(15);
            if(id === address_a){
                marker1.setPosition(pos);
                // map.fitBounds(new google.maps.LatLngBounds(pos, marker2.getPosition()));
            }else if(id === address_b){
                marker2.setPosition(pos);
                // map.fitBounds(new google.maps.LatLngBounds(pos, marker1.getPosition()));
            }
            goToAddress(pos,id);
            update();
        });

    }
}

function initAutocomplete(id) {
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{types: ['address']});
    autocomplete.setComponentRestrictions({'country': 'ua'});

    autocomplete.addListener('place_changed', function(){ fillInAddress(id)});
}

function fillInAddress(id) {

    document.getElementById(id).nextElementSibling.value = autocomplete.getPlace().geometry.location;
    if(id === address_a){
        marker1.setPosition(autocomplete.getPlace().geometry.location);
    }else if(id === address_b){
        marker2.setPosition(autocomplete.getPlace().geometry.location);
    }
    update('fitBounds');

}

function update(marker) {
    var path = [marker1.getPosition(), marker2.getPosition()];
    console.log(path[0].toString());
    console.log(path[1].toString());
    switch(marker) {
        case 'marker1':
            document.getElementById('coordinate_a').value = path[0].toString();
            setTimeout(function(){goToAddress(path[0],address_a)}, 1000);
            break;
        case 'marker2':
            document.getElementById('coordinate_b').value = path[1].toString();
            setTimeout(function(){goToAddress(path[1],address_b)}, 1000);
            break;
        case 'all':
            document.getElementById('coordinate_a').value = path[0].toString();
            setTimeout(function(){goToAddress(path[0],address_a)}, 1000);

            document.getElementById('coordinate_b').value = path[1].toString();
            setTimeout(function(){goToAddress(path[1],address_b)}, 1000);
    }

    /*var lng0 = +path[0].toString().split(', ')[1].split(')')[0];
     var lng1 = +path[1].toString().split(', ')[1].split(')')[0];
     if(lng0<lng1){
     console.log('<lng1');
     map.fitBounds(new google.maps.LatLngBounds(path[0],path[1]));
     }else if(lng0>lng1){
     console.log('lng0>');
     map.fitBounds(new google.maps.LatLngBounds(path[1],path[0]));
     }*/

    calculateAndDisplayRoute(path);
}

function goToAddress (pos,input){
    geocoder.geocode({'location': pos}, function(results, status) {

        console.log(results[0].formatted_address);

        document.getElementById(input).value = results[0].formatted_address;
    });
}

function calculateAndDisplayRoute(pos) {
    directionsService.route({
        origin: pos['0'],
        destination: pos['1'],
        travelMode: 'WALKING',
    }, function(response, status) {
        if (status == 'OK') {
            directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
        document.getElementById('distance').value = response.routes["0"].legs["0"].distance.value;
    });
}