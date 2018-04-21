<?php include "inc/header.php" ?>

<style>
.navbar-brand img {
    display: none;
    max-width: 300px;
    margin: 130px auto 0px;
}

.logo{
	padding: 20px 33px 50px;
}
</style>

<!--[if IE]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

<div class="container">
    <div class="header">

            <img class="logo" src="img/logo.svg" alt="Park Buffalo">

    </div>

    <div class="jumbotron text-center">
        <p class="lead">Enter the street address of the side of the street you're on. <br/> <br/> We'll look at Buffalo City Data to calculate the rules for your location.</p>
        <form action="response.php" method="post">
            <input type="text" autofocus class="form-control" id="autocomplete" onFocus="geolocate()" placeholder="Enter address closest to you...">
            <br/>

            <div class="col-12 storedfields">
                <label>Street Address</label>
                <input class="d-inline-block field" id="street_number" name="add_num" disabled="true">
                <input class="d-inline-block field" id="route" name="add_street" disabled="true">
                <input class="d-inline-block field" id="postal_code" name="zip" disabled="true">
            </div>

            <input class="btn btn-primary mt-1" type="submit" name="submit" value="Find Parking Rules">
        </form>


    </div>

	<div class="row marketing d-none">
        <div class="col-lg-12">
	        <table id="">
		        <tr>
		            <td class="label">Street address</td>
		            <td class="slimField"><input class="field" id="street_number" name="add_number" disabled="true"></td>
		            <td class="wideField" colspan="2"><input class="field" id="route" name="add_street" disabled="true"></td>
		        </tr>
		        <tr>
		            <td class="label">City</td>
		            <td class="wideField" colspan="3"><input class="field" id="locality" disabled="true"></td>
		        </tr>
		        <tr>
		            <td class="label">State</td>
		            <td class="slimField"><input class="field" id="administrative_area_level_1" disabled="true"></td>
		            <td class="label">Zip code</td>
		            <td class="wideField"><input class="field" id="postal_code" disabled="true"></td>
		        </tr>
		        <tr>
		            <td class="label">Country</td>
		            <td class="wideField" colspan="3"><input class="field" id="country" disabled="true"></td>
		        </tr>
		    </table>
        </div>
    </div>

	<!-- <iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJX_Rrz1sS04kR6EyJMWrLOfE&key=AIzaSyD5ttKC3CD6Z-o2pe96glix5xas4qSHfCQ" allowfullscreen></iframe>    -->



</div>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function(b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
            function() {
                (b[l].q = b[l].q || []).push(arguments)
            });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = 'https://www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X');
    ga('send', 'pageview');

</script>

<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1hgyqHWtrkaolwztdX5G_nc2nFdFgyis&libraries=places">

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(42.952523, -78.932614),
        new google.maps.LatLng(42.815877, -78.781552));

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */
            (document.getElementById('autocomplete')), {
                types: ['geocode'],
                bounds: defaultBounds,
                strictBounds: true,
                componentRestrictions: {
                    country: "us"
                }
            });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1hgyqHWtrkaolwztdX5G_nc2nFdFgyis&libraries=places&callback=initAutocomplete" async defer></script>

<?php include "inc/footer.php"?>
