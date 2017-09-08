var autocomplete;
function initAutocomplete(id) {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),
        {types: ['address']});
    autocomplete.setComponentRestrictions({'country': 'ua'});
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', function(){ fillInAddress(id)});
}

function fillInAddress(id) {

    document.getElementById(id).nextElementSibling.value = autocomplete.getPlace().geometry.location;

   if(document.getElementById('coordinate_a').value.length >1 && document.getElementById('coordinate_b').value.length>1){
       var origin1 = new google.maps.LatLng(document.getElementById('coordinate_a').value);
       var origin2 = document.getElementById('address_a').value;
       var destinationA = document.getElementById('address_b').value;
       var destinationB = new google.maps.LatLng(document.getElementById('coordinate_b').value);

       var service = new google.maps.DistanceMatrixService();
       service.getDistanceMatrix(
           {
               origins: [origin1, origin2],
               destinations: [destinationA, destinationB],
               travelMode: 'WALKING',
           }, callback);

       function callback(response, status) {
           // See Parsing the Results for
           // the basics of a callback function.
           document.getElementById('distance').value = response.rows[1].elements[0].distance.value;
       }

   }


}
