/**
 * Created by D-Andreevich on 14.09.2017.
 */
var marker1, marker2, clickMap;
var map, geocoder, autocomplete, directionsDisplay, directionsService;
var address_a = 'address_a';
var address_b = 'address_b';
var token = $('#_token').attr('content');
var socketId = Echo.socketId();
var cityA, cityB;

function addMap() {
    var latlng = new google.maps.LatLng(49.9935, 36.230383);
    var mapOptions = {
        zoom: 13,
        center: latlng,
        // minZoom: 10,
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

    // This event listener calls addMarker() when the map is clicked.
    clickMap = google.maps.event.addListener(map, 'click', function(event) {
        addMarker(event.latLng);
    });

}

function addMarker(pos, marker = 'marker1'){
    if(typeof(marker1)=="undefined" && marker=="marker1"){
        // console.log('marker1');
        marker1 = new google.maps.Marker({
            map: map,
            icon: '../img/pos-a.svg',
            draggable: true,
            // label: 'A',
            position: pos
        });
        update('marker1');
        google.maps.event.addListener(marker1, 'mouseup', function () {
            update('marker1')
        });
    }else if(marker1 && typeof(marker2)=="undefined" || marker=="marker2"){
        // console.log('marker2');
        marker2 = new google.maps.Marker({
            map: map,
            icon: '../img/pos-b.svg',
            // label: 'B',
            draggable: true,
            position: pos
        });
        update('marker2');
        google.maps.event.addListener(marker2, 'mouseup', function () {
            update('marker2')
        });
    }else{
        console.log('del event');
        google.maps.event.removeListener(clickMap);
    }
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
                if(typeof(marker1)=="undefined"){
                    addMarker(pos,'marker1');
                }else{
                    marker1.setPosition(pos);
                    update('marker1');
                }
            } else if (id === address_b) {
                if(typeof(marker2)=="undefined"){
                    addMarker(pos,'marker2');
                }else{
                    marker2.setPosition(pos);
                    update('marker2');
                }
            }
            goToAddress(pos, id);
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
        if(typeof(marker1)=="undefined"){
            addMarker(autocomplete.getPlace().geometry.location,'marker1');
        }else{
            marker1.setPosition(autocomplete.getPlace().geometry.location);
        }
    } else if (id === address_b) {
        if(typeof(marker2)=="undefined"){
            addMarker(autocomplete.getPlace().geometry.location,'marker2');
        }else{
            marker2.setPosition(autocomplete.getPlace().geometry.location);
        }
    }
    update('rout');

}

function update(marker) {
    switch (marker) {
        case 'marker1':
            var marker1Pos = marker1.getPosition();
            document.getElementById('coordinate_a').value = marker1Pos.toString();
            map.setCenter(marker1Pos);
            setTimeout(function () {
                goToAddress(marker1Pos, address_a)
            }, 1000);
            break;
        case 'marker2':
            var marker2Pos = marker2.getPosition();
            document.getElementById('coordinate_b').value = marker2Pos.toString();
            setTimeout(function () {
                goToAddress(marker2Pos, address_b)
            }, 1000);
            break;
        case 'all':
            var marker1Pos = marker1.getPosition();
            var marker2Pos = marker2.getPosition();
            document.getElementById('coordinate_a').value = marker1Pos.toString();
            setTimeout(function () {
                goToAddress(marker1Pos, address_a)
            }, 1000);

            document.getElementById('coordinate_b').value = marker2Pos.toString();
            setTimeout(function () {
                goToAddress(marker2Pos, address_b)
            }, 1000);
    }

    if(typeof(marker1)!="undefined" && typeof(marker2)!="undefined"){
        var path = [marker1.getPosition(), marker2.getPosition()];
        calculateAndDisplayRoute(path);
    }

}

function goToAddress(pos, input) {
    geocoder.geocode({'location': pos}, function (results, status) {
        document.getElementById(input).value = results[0].formatted_address;
        for (var data in results) {
            if (results[data].types == 'postal_code') {
                console.log(results[data].address_components[1].long_name);
                if (input === address_a) {
                    cityA = results[data].address_components[1].long_name;
                }else if (input === address_b){
                    cityB = results[data].address_components[1].long_name;
                }
                break;
            }
        }
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
        document.getElementById('distance').value = response.routes["0"].legs["0"].distance.value;
    });
}

function calculatePrice() {
    var seatsAmount = (document.getElementsByName('width')["0"].value/100)* (document.getElementsByName('height')["0"].value/100) * (document.getElementsByName('depth')["0"].value/100);
    seatsAmount = Math.ceil(seatsAmount);
    var amount = document.getElementsByName('quantity')['0'].value;
    var weight = document.getElementsByName('weight')['0'].value;
    var cost = document.getElementsByName('cost')['0'].value;

    var refCityA = cityForPrice(cityA);
    var refCityB = cityForPrice(cityB);

    var settings = {
        url: "https://api.novaposhta.ua/v2.0/json/",
        method: "POST",
        headers: {
            "content-type": "application/json",
        },
        data: "{" +
            "\"modelName\":\"InternetDocument\",\"calledMethod\":\"getDocumentPrice\",\"methodProperties\":{\"CitySender\":\""+refCityA+"\",\"CityRecipient\":\""+refCityB+"\",\"Weight\":\""+weight+"\",\"ServiceType\":\"DoorsDoors\",\"Cost\":\""+cost+"\",\"CargoType\":\"Cargo\",\"SeatsAmount\":\""+seatsAmount+"\",\"Amount\":\""+amount+"\"},\"apiKey\":\"665480f89e9ab0e692c6bba29ca33430\"" +
        "}"
    };

    $.ajax(settings).done(function(response){
        document.getElementById('price').value = response.data["0"].Cost;
    });
}

function cityForPrice(city) {
    console.log('socketId', socketId);
    var temp ='';
    var settings = {
        "url": "https://api.novaposhta.ua/v2.0/json/",
        "method": "POST",
        "headers": {
            "content-type": "application/json",
        },
        "data": "{\r\n\"apiKey\": \"665480f89e9ab0e692c6bba29ca33430\",\r\n \"modelName\": \"Address\",\r\n \"calledMethod\": \"getCities\",\r\n \"methodProperties\": {\r\n \"FindByString\": \""+city+"\"\r\n \r\n }\r\n}"
    };

    $.ajax(settings).done(function(response){
        temp = response.data["0"].Ref;
    });
    return temp;
}
