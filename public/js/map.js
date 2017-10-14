var map, geocoder, circle;
var infoWindow;
var latlng, myPosition,elemInputSlider ;

function ipApiGeo() {
    try {
        console.log('first-ip to');
        $.getJSON("//freegeoip.net/json/", function (data) {
            console.log('first-ip in');
            latlng = new google.maps.LatLng(data.latitude, data.longitude);

            editCircle(2);

            map.setCenter(latlng);

            geocodeLatLng(latlng);
        });
    } catch (err) {
        console.log('second-ip to');
        $.getJSON("//api.sypexgeo.net/json/?callback=", function (data) {
            console.log('second-ip in');
            latlng = new google.maps.LatLng(data.city.lat, data.city.lon);

            editCircle(2);

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
        fillColor: "#00AAFF",
        fillOpacity: 0.35,
        strokeColor: "#FFAA00",
        strokeOpacity: 0.5,
        strokeWeight: 2,
        clickable: false,
        editable: false, //test
        draggable: false,
        visible: true
    };

    // Get slider value
    $("#slider").slider({});
    $("#slider").change("slide", function(slideEvt) {
        $("#slider").text(slideEvt.value);
        console.log(slideEvt.value.newValue);
        elemInputSlider = slideEvt.value.newValue;
        editCircle(elemInputSlider);
    });

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
            latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            map.setCenter(latlng);
            geocodeLatLng(latlng);
        }, errorHandler);
    } else {
        console.log('else');
    }

    getOrdersByRadius();

    setInterval(getOrdersByRadius, 15000);

    // elemInputSlider.addEventListener( "change" , function() {editCircle(this.value)});
    // google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
    // });
}

function editCircle(radius){
    printMarkers(radius);

    circle.setRadius(radius*1000);
    circle.setCenter(latlng);
    circle.setMap(map);

    map.fitBounds(circle.getBounds());
}

function geocodeLatLng(latlng) {
    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === 'OK') {
            for (var data in results) {
                if (results[data].types == 'postal_code') {
                    console.log(results[data].address_components[1].long_name);
                    document.getElementById('geocity').innerHTML = results[data].address_components[1].long_name;
                    break;
                }
            }
            var image = './img/current_position.svg';
            myPosition = new google.maps.Marker({
                position: latlng,
                map: map,
                icon: image,
                title: 'Я тута!'
            });
        }
    });
}

var array_markers = [];
var caunt_array_markers;
var onMap = [];

function getOrdersByRadius() {
    var radius = 25;
    var image = './img/marker.svg';
    console.log(array_markers.length);
    $.ajax({
        type: 'GET',
        url:'/ordersr',
        dataType: "json",
        data: {'lat':latlng.lat(), 'lng': latlng.lng(), 'radius':radius},
        success:function(orders){
            console.log(orders);
            if(array_markers.length < orders.length){
                caunt_array_markers = array_markers.length;
                console.log('caunt_array_markers = '+caunt_array_markers);
                array_markers = orders;
                console.log('yes');
                for (var i = caunt_array_markers; i < array_markers.length; i++) {
                    onMap[i] = new google.maps.Marker({
                        // animation: google.maps.Animation.DROP,
                        position: new google.maps.LatLng(array_markers[i].lat, array_markers[i].lng),
                        // map: map,
                        icon: image
                    });
                }
                printMarkers(elemInputSlider);
            }else{
                console.log('orders.length = '+orders.length);
            }
        }



    });
}

function printMarkers(radius){
    console.log('onMap');
    console.log(onMap);
    for (var i = 0; i < onMap.length; i++) {
        var posMarker = onMap[i].position;
        if (distHaversine(posMarker, latlng) < radius) {
            onMap[i].setMap(map);
        }else{
            onMap[i].setMap(null);
        }
    }
}

//эта функция используются для определения расстояния между точками на
//поверхности Земли, заданных с помощью географических координат
//результат возвращается в км
function distHaversine(p, q){
    var R = 6371; // Earth radius in km
    console.log('p.lat() = ' + p.lat());
    console.log('q.lat() = ' + q.lat());

    var dLat = ((q.lat() - p.lat()) * Math.PI / 180);
    var dLon = ((q.lng() - p.lng()) * Math.PI / 180);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(p.lat() * Math.PI / 180) * Math.cos(q.lat() * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    console.log('R * c');
    console.log(R * c);
    return R * c;
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
    document.getElementById('iw-size').textContent = data.size + ' см';
    document.getElementById('iw-weight').textContent = data.weight + ' кг';
    document.getElementById('iw-distance').textContent = data.distance;
    document.getElementById('iw-price').textContent = data.price + ' грн.';
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
    var autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)), {types: ['geocode']});
    autocomplete.setComponentRestrictions({'country': 'ua'});
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();

        document.getElementById('geocity').innerHTML = place.address_components["0"].long_name;

        latlng = place.geometry.location;

        if (myPosition) {
            var image = './img/current_position.svg';
            myPosition = new google.maps.Marker({
                map: map,
                position: latlng,
                icon: image
            });

        } else {
            myPosition.setPosition(latlng);
        }
        map.setCenter(latlng);
        editCircle(elemInputSlider);
    });
}