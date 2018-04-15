<!doctype html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>parking tickets</title>

    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <!-- build:css styles/main.css -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">

  </head>
  <body>
    <!--[if IE]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active">
            <a href="index.html">Home</a>
          </li>
          <li>
            <a href="#">About</a>
          </li>
        </ul>
        <h3 class="text-muted">Parking Rules</h3>
      </div>
      <div class="jumbotron text-center">
        <p class="lead">Enter the street address you're closest to</p>
	    <input type="text" class="form-control" id="autocomplete"
             onFocus="geolocate()" placeholder="Street address...">
	    <br/>

 
    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

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
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1hgyqHWtrkaolwztdX5G_nc2nFdFgyis&libraries=places&callback=initAutocomplete"
        async defer></script>
	     
	    
	    <a class="btn btn-lg btn-success btn-default" type="button" href="response.html">Find Parking Rules!</a>
      </div>

      <div class="row marketing">
	    <div class="col-lg-12">
		    <h2> How it Works</h2>
	    </div>  
	    <hr>
        <div class="col-lg-12">
          <h4>1. Enter the house number and street you're closest to</h4>
          <p>HTML5 Boilerplate is a professional front-end template for building fast, robust, and adaptable web apps or sites.</p>

          <h4>2. Get the parking rules at your location</h4>
          <p>Sass is the most mature, stable, and powerful professional grade CSS extension language in the world.</p>

          <h4>3. Park with confidence</h4>
          <p>Modernizr is an open-source JavaScript library that helps you build the next generation of HTML5 and CSS3-powered websites.</p>
        </div>
      </div>

      <div class="footer">
        <p>♥ from IHIutch, TommyCreenan, Watch84</p>
      </div>
    </div>
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='https://www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>


  </body>
</html>
