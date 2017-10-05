var map, geocoder;
var infoWindow;
var latlng;

function ipApiGeo() {
    try {
        ready(function () { // ymaps.
            var geolocation = ymaps.geolocation;
            console.log('geolocation');
            latlng = new google.maps.LatLng(geolocation.latitude, geolocation.longitude);
            document.getElementById('geocity').innerHTML = geolocation.city;
            map.setCenter(latlng);
        });
    } catch (err) {
        $.getJSON("//ip-api.com/json/?callback=?", function (data) {  //http:
            console.log('data');
            latlng = new google.maps.LatLng(data.lat, data.lon);
            var pos = {lat: data.lat, lng: data.lon};
            map.setCenter(latlng);
            // document.getElementById('geocity').innerHTML = data.city;
            geocodeLatLng({lat: data.lat, lng: data.lon});
        });
    }
}


function initMap() {
    latlng = new google.maps.LatLng(49.9935, 36.230383);

    var mapOptions = {
        zoom: 13,
        center: latlng,
        minZoom: 12,
        maxZoom: 18,
        mapTypeControl: false,
        streetViewControl: false
    };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    geocoder = new google.maps.Geocoder;

    infoWindow = new google.maps.InfoWindow({
        content: document.getElementById('info-content')
    });

    // Create a new StyledMapType object, passing it an array of styles,
    // and the name to be displayed on the map type control.
    var styledMapType = new google.maps.StyledMapType(
        [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "gamma": "1.00"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels",
                "stylers": [
                    {
                        "color": "#ba5858"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels",
                "stylers": [
                    {
                        "color": "#e57878"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "lightness": "65"
                    },
                    {
                        "saturation": "-100"
                    },
                    {
                        "hue": "#ff0000"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "saturation": "-100"
                    },
                    {
                        "lightness": "80"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.attraction",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "color": "#dddddd"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "color": "#dddddd"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#ba5858"
                    },
                    {
                        "saturation": "-100"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#ba5858"
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "hue": "#ff0036"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "color": "#dddddd"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#ba5858"
                    }
                ]
            }
        ],
        {name: 'Styled Map'});

    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');

    function errorHandler(err) {
        if (err.code == 1) {
            alert("Error: Access is denied!");
            ipApiGeo();
        }
        else if (err.code == 2) {
            //alert("Error: Position is unavailable!");
            ipApiGeo();
        }
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latlng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            geocodeLatLng(latlng);
            map.setCenter(latlng);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Я тута!'
            });
        }, errorHandler);
    } else {
        console.log('else');
    }

    google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
        readMarkers();
    });
}

function geocodeLatLng(latlng) {
    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === 'OK') {
            if (results[1]) {
                map.setZoom(11);
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                console.log(results[1].address_components["1"]);
                document.getElementById('geocity').innerHTML = results[1].address_components["1"].long_name;
            }
        }
    });
}

function readMarkers() {

    var markers = document.getElementsByTagName('marker');
    Array.prototype.forEach.call(markers, function (markerElem) {

        var data = {
            'order_id': markerElem.getAttribute('order_id'),
            'user_id': markerElem.getAttribute('user_id'),
            'url': '',
            'name': 'Краткая характеристика заказа',
            'address': markerElem.getAttribute('address').split(', ')[0],
            'size': markerElem.getAttribute('width') + '/' + markerElem.getAttribute('height') + '/' + markerElem.getAttribute('depth'),
            'weight': markerElem.getAttribute('weight'),
            'distance': markerElem.getAttribute('distance'),
            'price': markerElem.getAttribute('price'),
            'deadline': markerElem.getAttribute('time_of_receipt'),
            'point': {
                lat: Number(markerElem.getAttribute('lat')),
                lng: Number(markerElem.getAttribute('lng'))
            },
        };

        var image = './img/marker.svg';
        var marker = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            map: map,
            position: data.point,
            icon: image
        });
        marker.addListener('click', function () {
            infoWindow.open(map, marker);
            buildIWContent(data);
        });
    });
}

function buildIWContent(data) {
    /*document.getElementById('iw-icon').innerHTML = '<img class="hotelIcon" ' +
     'src="' + data.icon + '"/>';*/
    document.getElementById('iw-url').innerHTML = '<b><a href="' + data.url + '">' + data.name + '</a></b>';
    document.getElementById('iw-address').textContent = data.address;
    document.getElementById('iw-size').textContent = data.size;
    document.getElementById('iw-weight').textContent = data.weight;
    document.getElementById('iw-distance').textContent = data.distance;
    document.getElementById('iw-price').textContent = data.price;
    document.getElementById('iw-deadline').textContent = data.deadline;
    document.getElementById('order_id').dataset.id = data.order_id;
    document.getElementById('remove_order').dataset.id = data.order_id;
    document.getElementById('order_id').dataset.user_id = data.user_id;

    var user_id_guest = +document.getElementById('courier_id').innerHTML;

    if (user_id_guest == data.user_id) {
        document.getElementById('order_id').style.display = 'none';
        document.getElementById('remove_order').style.display = '';
    } else if (user_id_guest != data.user_id) {
        document.getElementById('order_id').style.display = '';
        document.getElementById('remove_order').style.display = 'none';

    }

}
