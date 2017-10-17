var data, trackStatus;
function getLocation() {
    navigator.geolocation.getCurrentPosition(function(position){
        data = {'lat':position.coords.latitude, 'lng':position.coords.longitude};
        $token = $('input[name=_token2]').val();
        //console.log({'lat':position.coords.latitude, 'lng':position.coords.longitude});
        $.ajax({
            type: 'POST',
            url: '/savepos',
            data: {
                '_token': $token,
                'data': data
            },
            success: function(data){
                //console.log(data);
            }
        });
    });
    //console.log(data);

};

startTrack();


//вызвать эту функцию у курьера когда он заберет заказ
function startTrack() {
    trackStatus = setInterval(getLocation, 1000);
    console.log(trackStatus);
}

// вызвать эту вункцияю у курьера когда он отменит/доставит заказ
function stopTrack() {
    clearInterval(trackStatus);
}
