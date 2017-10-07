var map, geocoder, circle;
var infoWindow;
var latlng;

function ipApiGeo() {
    try {
        ready(function () { // ymaps.
            var geolocation = ymaps.geolocation;
            console.log('geolocation');
            latlng = new google.maps.LatLng(geolocation.latitude, geolocation.longitude);
            document.getElementById('geocity').innerHTML = geolocation.city;

            editCircle(0.5);

            map.setCenter(latlng);
        });
    } catch (err) {
        $.getJSON("//ip-api.com/json/?callback=?", function (data) {  //http:
            console.log('data');
            latlng = new google.maps.LatLng(data.lat, data.lon);
            var pos = {lat: data.lat, lng: data.lon};

            editCircle(0.5);

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

    var elemInputSlider = document.getElementById("slider");

    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    circle = new google.maps.Circle(circleOptions);
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
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "weight": "2.00"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#9c9c9c"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "poi",
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
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#7b7b7b"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
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
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#c8d7d4"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#070707"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
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
            alert("Error: Position is unavailable!");
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
            editCircle(elemInputSlider.value);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Я тута!'
            });
        }, errorHandler);
    } else {
        console.log('else');
    }

    elemInputSlider.addEventListener( "change" , function() {editCircle(this.value)});

    google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
        readMarkers();
    });
}

function editCircle(radius){
    circle.setRadius(radius*1000);
    circle.setCenter(latlng);
    circle.setMap(map);

    map.fitBounds(circle.getBounds());
}

function geocodeLatLng(latlng) {
    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === 'OK') {
            for(var data in results){
                if(results[data].types == 'postal_code'){
                    console.log(results[data].address_components[1].long_name);
                    document.getElementById('geocity').innerHTML = results[data].address_components[1].long_name;
                    break;
                }
                /*var marker = new google.maps.Marker({
                 position: latlng,
                 map: map
                 });*/
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
