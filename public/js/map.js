var map, geocoder, circle;
var infoWindow;
var latlng, myPosition, elemInputSlider;

function ipApiGeo() {
    try {
        console.log('first-ip to');
        $.getJSON("//freegeoip.net/json/", function (data) {
            console.log('first-ip in');
            latlng = new google.maps.LatLng(data.latitude, data.longitude);

                // editCircle(0.5, latlng);

                map.setCenter(latlng);

                geocodeLatLng(latlng);
            });
    } catch (err) {
        console.log('second-ip to');
        $.getJSON("//api.sypexgeo.net/json/?callback=", function (data) {
            console.log('second-ip in');
            latlng = new google.maps.LatLng(data.city.lat, data.city.lon);

            // editCircle(0.5, latlng);

            map.setCenter(latlng);

            geocodeLatLng(latlng);
        });
    }
}


function initMap() {
    latlng = new google.maps.LatLng(49.9935, 36.230383);

    var mapOptions = {
        zoom: 13,
        center: latlng,
        minZoom: 10,
        maxZoom: 18,
        mapTypeControl: false,
        streetViewControl: false
    };

    var circleOptions = {
        fillColor:"#00AAFF",
        fillOpacity:0.35,
        strokeColor:"#FFAA00",
        strokeOpacity:0.5,
        strokeWeight:2,
        clickable:false,
        editable:false, //test
        draggable: false,
        visible: true
    };

    elemInputSlider = document.getElementById("slider");

    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    // circle = new google.maps.Circle(circleOptions);
    geocoder = new google.maps.Geocoder;

    infoWindow = new google.maps.InfoWindow({
        content: document.getElementById('info-content')
    });

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
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#a0a4a5"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
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
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
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

    function errorHandler(err) {
        if (err.code == 1) {
            alert("Вы не разрешили опредилить местоположение!");
            ipApiGeo();
        }
        else if (err.code == 2) {
            alert("Error: Position is unavailable!");
            ipApiGeo();
        }
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            latlng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            geocodeLatLng(latlng);

            map.setCenter(latlng);
            // editCircle(elemInputSlider.value, latlng);
        }, errorHandler);
    } else {
        console.log('else');
    }

    // elemInputSlider.addEventListener( "change" , function() {editCircle(this.value, latlng)});

    google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
        readMarkers();
    });
}

/*function editCircle(radius,latlng){
    circle.setRadius(radius*1000);
    circle.setCenter(latlng);
    circle.setMap(map);

    map.fitBounds(circle.getBounds());
}*/

function geocodeLatLng(latlng) {
    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === 'OK') {
            for(var data in results){
                if(results[data].types == 'postal_code'){
                    console.log(results[data].address_components[1].long_name);
                    document.getElementById('geocity').innerHTML = results[data].address_components[1].long_name;
                    break;
                }
            }
            myPosition = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Я тута!'
            });
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

function startAutocomplete(id) {
    var autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{types: ['geocode']});
    autocomplete.setComponentRestrictions({'country': 'ua'});
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function(){
        var place = autocomplete.getPlace();

        document.getElementById('geocity').innerHTML = place.address_components["0"].long_name;

        latlng = place.geometry.location;

        if(myPosition){
            myPosition = new google.maps.Marker({
                map: map,
                position: latlng,
            });

        }else {
            myPosition.setPosition(latlng);
        }
        map.setCenter(latlng);
        // editCircle(elemInputSlider.value, latlng);
    });
}