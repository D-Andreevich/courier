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
        streetViewControl: false
    };
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    infoWindow = new google.maps.InfoWindow({
        content: document.getElementById('info-content')
    });

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
        var address = markerElem.getAttribute('address').split(', ')[0];
        var size = markerElem.getAttribute('width') + '/' + markerElem.getAttribute('height') + '/' + markerElem.getAttribute('depth');
        var weight = markerElem.getAttribute('weight');
        var distance = markerElem.getAttribute('distance');
        var price = markerElem.getAttribute('price');
        var deadline = markerElem.getAttribute('time_of_receipt');

        var point = {
            lat: Number(markerElem.getAttribute('lat')),
            lng: Number(markerElem.getAttribute('lng'))
        };

        var html ='<div id="info-content">'+
            '<table>'+
            '<tr id="iw-url-row" class="iw_table_row">'+
            '<td id="iw-icon" class="iw_table_icon">'+
            '<img class="hotelIcon" src="https://lh3.googleusercontent.com/6a0yWwDMUKU-qfTwYUUANsRkiArCei25vob9O2CeLdYyKKtoZ7eh73QpJecSrv76tw=w128"/>'+
            '</td>'+
            '<td id="iw-url"> '+ name + ' </td>'+
            '</tr>'+
            '<tr id="iw-address-row" class="iw_table_row">'+
            '<td class="iw_attribute_name">Адрес: </td>'+
            '<td id="iw-address">' + address + '</td>'+
            '</tr>'+
            '<tr id="iw-address-row" class="iw_table_row">'+
            '<td class="iw_attribute_name">Габариты: </td>'+
            '<td id="iw-address">' + size + '</td>'+
            '</tr>'+
            '<tr id="iw-address-row" class="iw_table_row">'+
            '<td class="iw_attribute_name">Масса: </td>'+
            '<td id="iw-address">' + weight + '</td>'+
            '</tr>'+
            '<tr id="iw-phone-row" class="iw_table_row">'+
            '<td class="iw_attribute_name">Дистанция: </td>'+
            '<td id="iw-phone">' + distance + '</td>'+
            '</tr>'+
            '<tr id="iw-rating-row" class="iw_table_row">'+
            '<td class="iw_attribute_name">Стоимость: </td>'+
            '<td id="iw-rating">' + price + '</td>'+
            '</tr>'+
            '<tr id="iw-website-row" class="iw_table_row">'+
            '<td class="iw_attribute_name">Deadline: </td>'+
            '<td id="iw-website">' + deadline + '</td>'+
            '</tr>'+
            '</table>'+
            '</div>';

        var marker = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            map: map,
            position: point,
        });
        marker.addListener('click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
    });
}


