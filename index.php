<?php include "inc/header.php" ?>

<style>
    .navbar-brand img {
        display: none;
        max-width: 300px;
        margin: 130px auto 0px;
    }

    .logo {
        padding: 20px 33px 50px;
    }
</style>
<script>
    function init() {
    // Clear forms here
    document.getElementById("searchTextField").value = "";
    document.getElementById("street_number").value = "";
}
window.onload = init;
</script>

<div class="container">
    <div class="header">

        <img class="logo" src="img/logo.svg" alt="Park Buffalo">

    </div>

    <div class="jumbotron text-center">
        <p class="lead">Enter the street address of current location. <br/> <br/> We'll look at Buffalo City Data to calculate the rules for your location.</p>

        <div class="col-12">
            <div class="form-group">
                <input type="text" autofocus class="form-control" id="searchTextField" placeholder="Enter your current address here..." required>
                <div class="invalid-feedback">Please enter a valid address</div>
            </div>
        </div>
        <br/>
        <form id="form" action="response.php" method="post">
            <div class="col-12 d-none">
                <label>Street Address</label>
                <input type="text" class="d-inline form-control" id="street_number" name="add_num" required>
                <input type="text" class="d-inline form-control" id="route" name="add_street" disabled="true">
                <input type="text" class="d-inline form-control" id="postal_code" name="zip" disabled="true">
            </div>

            <input class="btn btn-primary mt-1" type="submit" name="submit" id="btnSubmit" value="Find Parking Rules">
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

</div>
<script>
    $("#btnSubmit").click(function(event) {

        // Fetch form to apply custom Bootstrap validation
        var form = $("#form")

        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }

        form.addClass('was-validated');
        // Perform ajax submit here...

    });

</script>

<script>
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
        var input = document.getElementById('searchTextField');
        var options = {
            bounds: defaultBounds,
            types: ['address'],
            componentRestrictions: {
                locality: 'Buffalo'
            }
        };

        autocomplete = new google.maps.places.Autocomplete(input, options);
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
    //    function geolocate() {
    //        if (navigator.geolocation) {
    //            navigator.geolocation.getCurrentPosition(function(position) {
    //                var geolocation = {
    //                    lat: position.coords.latitude,
    //                    lng: position.coords.longitude
    //                };
    //                var circle = new google.maps.Circle({
    //                    center: geolocation,
    //                    radius: position.coords.accuracy
    //                });
    //                autocomplete.setBounds(circle.getBounds());
    //            });
    //        }
    //    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1hgyqHWtrkaolwztdX5G_nc2nFdFgyis&libraries=places&callback=initAutocomplete" async defer></script>

<?php include "inc/footer.php"?>
