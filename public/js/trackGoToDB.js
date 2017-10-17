var data, trackStatus;
function getLocation() {
    navigator.geolocation.getCurrentPosition(function(position){
        data = {'lat':position.coords.latitude, 'lng':position.coords.longitude};
        console.log({'lat':position.coords.latitude, 'lng':position.coords.longitude});
    });
    console.log(data);
    $.ajax({
        type: 'POST',
        url: '/savepos',
        data: data,
        success: function(data){
            console.log(data);
        }
    });
}

//вызвать эту функцию у курьера когда он заберет заказ
function startTrack() {
    trackStatus = setInterval(getLocation, 5000);
}

// вызвать эту вункцияю у курьера когда он отменит/доставит заказ
function stopTrack() {
    clearInterval(trackStatus);
}
