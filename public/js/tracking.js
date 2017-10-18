var lat, lng;
var map;
var mark, latlng;
var lineCoords = [];

var lineSymbol;


function getLocation() {
    var image = '/img/courier.svg';
    console.log(image);
    $order_id = window.location.pathname;
    $order_id = +$order_id.split("order/")[1].split('/tracking')[0];
    $.ajax({
        type: 'GET',
        url:'/getPosition',
        dataType: 'json',
        data: {
            'order_id': $order_id
        },
        success: function(orders) {
            console.log(orders);
            lat = orders[0].lat;
            lng = orders[0].lng;
            // pubnub.publish({channel: pnChannel, message: {'lat':orders[0].lat, 'lng':orders[0].lng}});
            if(typeof(mark)=="undefined") {
                map.setCenter({lat:lat, lng:lng, alt:0});
                mark = new google.maps.Marker({
                    position: {lat: lat, lng: lng},
                    map: map,
                    icon: image
                    //label: 'Z'
                });
            }else {
                map.setCenter({lat:lat, lng:lng, alt:0});

                mark.setPosition({lat:lat, lng:lng, alt:0});
            }
        },
        error: function () {
            console.log('error');
        }
    });
}

function initialize() {
    lat = 49.9873852;
    lng = 36.2309033;
    var mapOptions = {
        zoom: 13,
        center: {lat:lat, lng:lng},
        minZoom: 10,
        maxZoom: 18,
        mapTypeControl: false,
        streetViewControl: false
    };
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            map.setCenter({lat:lat, lng:lng, alt:0});
            // mark.setPosition({lat:lat, lng:lng, alt:0});
        });
    } else {
        console.log('else geolocation');
    }

    map  = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

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

    // lineCoords.push(new google.maps.LatLng(lat, lng));

    lineSymbol =  {
        path: google.maps.SymbolPath.CIRCLE,
        fillOpacity: 1,
        scale: 3
    };
};

var redraw = function(payload) {
    // console.log(payload);
    lat = payload.message.lat;
    lng = payload.message.lng;

    map.setCenter({lat:lat, lng:lng, alt:0});
    mark.setPosition({lat:lat, lng:lng, alt:0});
    // lineCoords.push(new google.maps.LatLng(lat, lng));
    var lineCoordinatesPath = new google.maps.Polyline({
        path: lineCoords,
        geodesic: true,
        /*strokeColor: '#2E10FF',
         strokeOpacity: 0.6,
         strokeWeight: 6*/
        strokeColor: 'blue',
        strokeWeight: 6,
        strokeOpacity: 0,//0.1
        icons: [{
            icon: lineSymbol,
            offset: '0',
            repeat: '10px'
        }],
    });

    // lineCoordinatesPath.setMap(map);
};

var pnChannel = "map-channel";
var pubnub = new PubNub({
    publishKey: 'pub-c-9e2c4fd9-945a-4975-b9a3-b89db0a6f23a',
    subscribeKey: 'sub-c-ec31e894-b287-11e7-af03-56d0cae65fed'
});

pubnub.subscribe({channels: [pnChannel]});
pubnub.addListener({message:redraw});

//при полной реализации убрать функцию как оболочку
    setInterval(getLocation, 800);