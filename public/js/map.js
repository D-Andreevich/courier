var map;
var infoWindow;

function initMap() {
    var latlng = new google.maps.LatLng(49.9935, 36.230383);
    var mapOptions = {
        zoom: 13,
        center: latlng,
        minZoom: 12,
        maxZoom: 18,
        mapTypeControl: false,

    };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    infoWindow = new google.maps.InfoWindow;

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

    google.maps.event.addListenerOnce(map, 'tilesloaded', function () {
        readMarkers();
    });
}

function readMarkers() {

    var markers = document.getElementsByTagName('marker');
    Array.prototype.forEach.call(markers, function(markerElem) {
        var name = 'Краткая характеристика заказа';
        var address = 'Адресс: ' +  markerElem.getAttribute('address').split(', ')[0];
        var size = 'Габариты: ' +  markerElem.getAttribute('width') + '/' + markerElem.getAttribute('height') + '/' + markerElem.getAttribute('depth');
        var weight = 'Вес: ' +   markerElem.getAttribute('weight');
        var distance = 'Дистанция: ' +  markerElem.getAttribute('distance');
        var price = 'Стоимость: ' +  markerElem.getAttribute('price');
        var deadline = 'Дедлайн: ' + markerElem.getAttribute('time_of_receipt');

        var point = {
            lat: Number(markerElem.getAttribute('lat')),
            lng: Number(markerElem.getAttribute('lng'))
        };

        var infowincontent = document.createElement('div');
        var strong = document.createElement('strong');
        strong.textContent = name;
        infowincontent.appendChild(strong);
        infowincontent.appendChild(document.createElement('br'));
        var text = document.createElement('text');
        text.textContent = address + '<br>' + size + '<br>' + weight + '<br>' + distance + '<br>' + price + '<br>' + deadline;
        infowincontent.appendChild(text);
        infowincontent.appendChild(document.createElement('br'));

        //инфо виндов в стадии разработки ждите...

        var marker = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            map: map,
            position: point,
        });
        marker.addListener('click', function() {
            infoWindow.setContent(infowincontent);
            infoWindow.open(map, marker);
        });
    });
}
