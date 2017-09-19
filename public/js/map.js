var map, geocoder;
var infoWindow;
var latlng;

function ipApiGeo() {
    try {
        ready(function(){
            var geolocation = ymaps.geolocation;
            console.log('geolocation');
            latlng = new google.maps.LatLng(geolocation.latitude,geolocation.longitude);
            document.getElementById('geocity').innerHTML = geolocation.city ;
            map.setCenter(latlng);
        });
    } catch (err) {
        $.getJSON("//ip-api.com/json/?callback=?", function (data) {
            console.log('data');
            latlng = new google.maps.LatLng(data.lat, data.lon);
            var pos ={lat: data.lat, lng: data.lon};
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

    function errorHandler(err) {
        if(err.code == 1) {
            alert("Error: Access is denied!");
            ipApiGeo();
        }
        else if( err.code == 2) {
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
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Я тута!'
            });
        },errorHandler);
    }else {
        console.log('else');
    }

    google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
        readMarkers();
    });
}

function geocodeLatLng(latlng) {
    geocoder.geocode({'location': latlng}, function(results, status) {
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
    Array.prototype.forEach.call(markers, function(markerElem) {

        var data = {
            'order_id':markerElem.getAttribute('order_id'),
            'user_id':markerElem.getAttribute('user_id'),
            'url': '',
            'name': 'Краткая характеристика заказа',
            'address': markerElem.getAttribute('address').split(', ')[0],
            'size': markerElem.getAttribute('width') + '/' + markerElem.getAttribute('height') + '/' + markerElem.getAttribute('depth'),
            'weight': markerElem.getAttribute('weight'),
            'distance': markerElem.getAttribute('distance'),
            'price': markerElem.getAttribute('price'),
            'deadline': markerElem.getAttribute('time_of_receipt'),
            'point':{
                lat: Number(markerElem.getAttribute('lat')),
                lng: Number(markerElem.getAttribute('lng'))
            },
        };

        var marker = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            map: map,
            position: data.point,
        });
        marker.addListener('click', function() {
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

    var user_id_guest = +document.getElementById('courierId').innerHTML;

    if(user_id_guest == data.user_id){
        document.getElementById('order_id').style.display='none';
    }else if(user_id_guest != data.user_id){
        document.getElementById('order_id').style.display='';
    }

}
