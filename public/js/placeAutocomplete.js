var placeSearch, autocomplete;
function initAutocomplete(id) {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),
        {types: ['address']});
    autocomplete.setComponentRestrictions({'country': 'ua'});
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    var place = autocomplete.getPlace();
}