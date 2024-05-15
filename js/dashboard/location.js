function initialize() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(latLng);
            map.setZoom(12);
            geocoder.geocode({'location': latLng}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        addressInput.value = results[0].formatted_address;
                        updateAddressComponents(results[0]);
                    } else {
                        alert('No results found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
        });
    } else {
        alert('Geolocation is not supported by this browser.');
    }    
}

function initializeAutocomplete(country) {
    var addressInput = document.getElementById('jobcircle-address');
    var countrySelect = document.getElementById('jobcircle-country');
    var stateSelect = document.getElementById('jobcircle-state');
    var input = document.getElementById('autocomplete');
    var options = {
        types: ['geocode'], // Return only geocoding results
        componentRestrictions: {
            country: countrySelect.value, // Restrict results to a specific country (e.g., United States)
            administrativeArea: stateSelect.value // Optionally, restrict results to a specific state (e.g., California)
        }
    };
    var autocomplete = new google.maps.places.Autocomplete(addressInput, options);
}

jQuery(document).ready(function($) {
    function initializeAutocomplete() {
        var selectedCountryCode = $('#jobcircle-country option:selected').data("country_code");
        var options = {};    
        if (selectedCountryCode) {
            // If a country code is selected, set componentRestrictions
            options.componentRestrictions = { country: selectedCountryCode };
        }    
        var input = document.getElementById('jobcircle-address');
        if (input !== null) {
            if (typeof google !== 'undefined') {  
                var autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete_place_changed(autocomplete);
            }
        }
    }

    function autocomplete_place_changed(autocomplete){
        // When a place is selected from the autocomplete suggestions
        if (typeof google !== 'undefined') {
            google.maps.event.addListener(autocomplete, 'place_changed', function () {   
                
                var place = autocomplete.getPlace();
                // You can access various properties of the selected place
                var formattedAddress = place.formatted_address;
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                var addressComponents = place.address_components;
                var zipcode = '';
                var city = '';    
                // Loop through address components to find the zipcode
                for (var i = 0; i < addressComponents.length; i++) {
                    var component = addressComponents[i];
                    if (component.types.includes('postal_code')) {
                        zipcode = component.long_name;
                    } else if (component.types.includes('locality')) {
                        city = component.long_name;
                    }
                }
                // Set the values in hidden fields
                $('#jobcircle-address').val(formattedAddress);
                
                if(city){
                    $('#jobcircle-city').val(city);
                }

                if(zipcode){
                    $('#jobcircle-zipcode').val(zipcode);
                }            
                $('#jobcircle-latitude').val(latitude);
                $('#jobcircle-longitude').val(longitude);                
            });
        }    
        
    }

    $(document).on('keyup', '#jobcircle-address', function() {
        initializeAutocomplete();
    });
    
    $(document).on('change', '#jobcircle-country', function() {
        initializeAutocomplete();
    });

    $(document).on('change', '#jobcircle-country', function(e) {
        e.preventDefault();
        let selectedCountry = $(this).val();
        let selectedcountry_code = $('#jobcircle-country option:selected').data("country_code");

        if(selectedcountry_code){
            var this_btn = jQuery(this);
            var this_par = this_btn.parents('.jobcircle-dashb-form');
            this_par.append('<div class="jobcircle-loder-con"><div class="jobcircle-loder-iner"><div class="jobcircle-loader"></div></div></div>');
            $('#jobcircle-state').empty();
            $.ajax({
                url: jobcircle_location_vars.ajax_url, // WordPress AJAX URL
                type: 'post',
                data: {
                    action: 'jobcircle_get_states', // AJAX action name
                    country: selectedCountry,
                    country_code: selectedcountry_code
                },
                success: function(response) {                    
                    // Populate state dropdown with response data
                    this_par.find('.jobcircle-loder-con').remove();
                    $.each(response, function(key, value) {
                        $('#jobcircle-state').append('<option value="' + value + '" data-state_code="' + key + '">' + value + '</option>');
                    });
                    initializeAutocomplete();
                }
            });
        }
    });    

    $(document).on('keydown', '#jobcircle-address', function(e) {
        if (e.keyCode === 13) { // Check if Enter key is pressed
            e.preventDefault(); // Prevent default form submission behavior
        }
    });
});