var lat, lng;
var map;
var mark, latlng;
var lineCoords = [];

var lineSymbol;


function getLocation() {
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
            pubnub.publish({channel: pnChannel, message: {'lat':orders[0].lat, 'lng':orders[0].lng}});
            console.log({'lat':orders[0].lat, 'lng':orders[0].lng});
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
            mark.setPosition({lat:lat, lng:lng, alt:0});
        });
    } else {
        console.log('else geolocation');
    }

    map  = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    mark = new google.maps.Marker({
        position:{lat:lat, lng:lng},
        map:map,
        // icon: ,
        label: 'Z'
    });

    // lineCoords.push(new google.maps.LatLng(lat, lng));

    lineSymbol =  {
        path: google.maps.SymbolPath.CIRCLE,
        fillOpacity: 1,
        scale: 3
    };
};

var redraw = function(payload) {
    console.log(payload);
    lat = payload.message.lat;
    lng = payload.message.lng;
    map.setCenter({lat:lat, lng:lng, alt:0});
    mark.setPosition({lat:lat, lng:lng, alt:0});
    lineCoords.push(new google.maps.LatLng(lat, lng));
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