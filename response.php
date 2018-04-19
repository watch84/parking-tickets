<?php include "inc/header.php"?>

<?php createRows();?>
    <!--[if IE]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="container">
      <div class="header">
<!--
        <a href="/">
	        <img class="logo" src="/img/logo.svg" alt="">
        </a>
-->
      </div>
	  <div class="row response-container">
		  <div class="col-sm-12">
		  	<h1 class="street-message">640 Ellicott St.</h1>
<!-- 		  	<div class="col-sm-12">The parking rules at your current location are:</div> -->
		  </div>
		  <div class="col-sm-12">
	
				<p class="message">
<!-- .message-good on co	PARKING AVAILABLE -->
					NO PARKING
				</p>
				<ul>
				  <li><p>Monday: 8am-6pm</p></li>
				  <li><p>Tuesday: 8am-6pm</p></li>
				  <li><p>Wednesday: 8am-6pm</p></li>
				  <li class="current-rule-container">
				  	<p class="current-rule">Thursday: 8am-6pm</p>
				  	<p class="rule-support">It's currently Thursday at 3:47 PM.</p>
				  </li>
				  <li><p>Friday: 8am-6pm</p></li>
				  <li><p>Saturday: 8am-6pm</p></li>
				  <li><p>Sunday: 8am-6pm</p></li>
<!--
				  
				  <select>
					  <option>English &#8675;</option>
					  <option>Spanish</option>
					  <option>Burmese</option>
					  <option>Karen</option>
					  <option>Arabic</option>
					  <option>Nepali</option>
				  </select>
-->
				  <div id="google_translate_element"></div>
				  <script type="text/javascript">
					function googleTranslateElementInit() {
					  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
					}
					</script>
					<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
				</ul>
				
				
		  </div>
		  <div class="col-sm-12">
			  <p class="notice">All calculations have been made using summons data collected during parking violations. Park smarter.</p>
		  </div>
		  <div class="col-sm-12 parking-response">

			  <div class="col-sm-12">
		          <?php
		          ini_set('display_errors', 1);
		          ini_set('display_startup_errors', 1);
		          error_reporting(E_ALL);
		
		          $fetch = "SELECT * FROM parking_times";
		
		          $result = $con->query($fetch);
		
		          if ($result->num_rows > 0) {
		              // output data of each row
		              while($row = $result->fetch_assoc()) {
		                  $today = date("D");
		
		                  $street = $row["streetname"];
		                  $street = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($street))));
		
		                  $string = $row["parking_time"];
		                  $json = json_decode($string, true);
		
		                  echo $street. "<br>";
		                  echo $today. "<br>";
		                  // print_r($json);
		                  if (is_array($json)[$today]) {
		                    foreach ($json[$today] as $t) {
		                      echo "Start Time:". $t['mintime'] ."\n";
		                    };
		                  }
		              }
		          } else {
		              echo "No Results.";
		          }
		
		          $con->close();
		          ?>

			   </div>
		  </div>
	  </div>
	 
      <div class="footer">
        
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




<?php include "inc/footer.php"?>