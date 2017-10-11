/**
 * Created by D-Andreevich on 14.09.2017.
 */
var marker1, marker2;
var map, geocoder, autocomplete, directionsDisplay, directionsService;
var address_a = 'address_a';
var address_b = 'address_b';

/*var latlng;
 $(document).ready(function(){
 ymaps.ready(function(){
 var geolocation = ymaps.geolocation;
 latlng = new google.maps.LatLng(geolocation.latitude, geolocation.longitude);
 });
 });*/

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
    map = new google.maps.Map(document.getElementById('addMap'), mapOptions);

    // Create a new StyledMapType object, passing it an array of styles,
    // and the name to be displayed on the map type control.
    var styledMapType = new google.maps.StyledMapType(
        [
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#7c93a3"
                    },
                    {
                        "lightness": "-10"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#a0a4a5"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#62838e"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#dde3e3"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#3f4a51"
                    },
                    {
                        "weight": "0.30"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "poi.attraction",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.government",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.place_of_worship",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.school",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-100"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#bbcacf"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "lightness": "0"
                    },
                    {
                        "color": "#bbcacf"
                    },
                    {
                        "weight": "0.50"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#a9b4b8"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "invert_lightness": true
                    },
                    {
                        "saturation": "-7"
                    },
                    {
                        "lightness": "3"
                    },
                    {
                        "gamma": "1.80"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": '#a9b4b8'
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#a3c7df"
                    }
                ]
            }
        ],
        {name: 'Styled Map'});

    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');

    geocoder = new google.maps.Geocoder;

    directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: true, // не использовать маркеры
        polylineOptions: {
            strokeColor: "#292929",
            strokeWeight: 4
        }
    });
    directionsService = new google.maps.DirectionsService;
    directionsDisplay.setMap(map);

    marker1 = new google.maps.Marker({
        map: map,
        icon: '../img/pos-a.svg',
        draggable: true,
        // label: 'A',
        position: {lat: 49.9942, lng: 36.230391}
    });

    marker2 = new google.maps.Marker({
        map: map,
        icon: '../img/pos-b.svg',
        // label: 'B',
        draggable: true,
        position: {lat: 49.97930368719336, lng: 36.24643119685061}
    });

    google.maps.event.addListener(marker1, 'mouseup', function () {
        update('marker1')
    });
    google.maps.event.addListener(marker2, 'mouseup', function () {
        update('marker2')
    });

    update('all');
}

function myPosition(id) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(pos);
            map.setZoom(15);
            if (id === address_a) {
                marker1.setPosition(pos);
                // map.fitBounds(new google.maps.LatLngBounds(pos, marker2.getPosition()));
            } else if (id === address_b) {
                marker2.setPosition(pos);
                // map.fitBounds(new google.maps.LatLngBounds(pos, marker1.getPosition()));
            }
            goToAddress(pos, id);
            update();
        });

    }
}

function initAutocomplete(id) {
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {types: ['address']});
    autocomplete.setComponentRestrictions({'country': 'ua'});

    autocomplete.addListener('place_changed', function () {
        fillInAddress(id)
    });
}

function fillInAddress(id) {

    document.getElementById(id).nextElementSibling.value = autocomplete.getPlace().geometry.location;
    if (id === address_a) {
        marker1.setPosition(autocomplete.getPlace().geometry.location);
    } else if (id === address_b) {
        marker2.setPosition(autocomplete.getPlace().geometry.location);
    }
    update('fitBounds');

}

function update(marker) {
    var path = [marker1.getPosition(), marker2.getPosition()];
    console.log(path[0].toString());
    console.log(path[1].toString());
    switch (marker) {
        case 'marker1':
            document.getElementById('coordinate_a').value = path[0].toString();
            setTimeout(function () {
                goToAddress(path[0], address_a)
            }, 1000);
            break;
        case 'marker2':
            document.getElementById('coordinate_b').value = path[1].toString();
            setTimeout(function () {
                goToAddress(path[1], address_b)
            }, 1000);
            break;
        case 'all':
            document.getElementById('coordinate_a').value = path[0].toString();
            setTimeout(function () {
                goToAddress(path[0], address_a)
            }, 1000);

            document.getElementById('coordinate_b').value = path[1].toString();
            setTimeout(function () {
                goToAddress(path[1], address_b)
            }, 1000);
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

function goToAddress(pos, input) {
    geocoder.geocode({'location': pos}, function (results, status) {

        console.log(results[0].formatted_address);

        document.getElementById(input).value = results[0].formatted_address;
    });
}

function calculateAndDisplayRoute(pos) {
    directionsService.route({
        origin: pos['0'],
        destination: pos['1'],
        travelMode: 'WALKING',
    }, function (response, status) {
        if (status == 'OK') {
            directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
        console.log(response);
        document.getElementById('distance').value = response.routes["0"].legs["0"].distance.value;
    });
}