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
        </a> -->
    </div>
    <div class="row response-container">
        <div class="col-sm-12">


            <h1 class="street-message">
                <?php echo $_POST['add_num'] . ' ' . $_POST['add_street']?>
            </h1>
            <!-- 		  	<div class="col-sm-12">The parking rules at your current location are:</div> -->
        </div>
        <div class="col-sm-12">

            <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                $fetch = "SELECT * FROM parking_times";

                $today = date("D");
                $time = date("H:i a");

                $result = $con->query($fetch);
                $add_street = $_POST['add_street'];
                $street = strtolower(preg_replace('/\W\w+\s*(\W*)$/', '$1', $add_street));

                while($row = $result->fetch_assoc()) {

                $streetname = strtolower($row['streetname']);

                if($street == $streetname){
                    $times = $row['parking_time'];
                    $untimes = json_decode($times,true);
            
            
                    
            if (isset($untimes[$today])){ 
               if ($time > date("H:i a", strtotime($untimes[$today]['mintime'])) && $time < date("H:i a", strtotime($untimes[$today]['maxtime']))) { ?>
                <p class="message">PAY TO PARK</p>
                <?php } else{ ?>
                <p class="message-good">FREE PARKING</p>
                <?php  } ?>
                <?php } elseif(!isset($untimes[$today])) {?>
                <p class="message-good">FREE PARKING</p>
                <?php } ?>

                <ul>
                    <?php if(isset($untimes['Mon'])) { ?>
                    <li>
                        <p>Monday:
                            <?php echo date("g:i a", strtotime($untimes['Mon']['mintime']))?> -
                            <?php echo date("g:i a", strtotime($untimes['Mon']['maxtime']))?>
                        </p>
                    </li>
                    <?php } if(isset($untimes['Tue'])) { ?>
                    <li>
                        <p>Tuesday:
                            <?php echo date("g:i a", strtotime($untimes['Tue']['mintime']))?> -
                            <?php echo date("g:i a", strtotime($untimes['Tue']['maxtime']))?>
                        </p>
                    </li>
                    <?php } if(isset($untimes['Wed'])) { ?>
                    <li>
                        <p>Wednesday:
                            <?php echo date("g:i a", strtotime($untimes['Wed']['mintime']))?> -
                            <?php echo date("g:i a", strtotime($untimes['Wed']['maxtime']))?>
                        </p>
                    </li>
                    <?php } if(isset($untimes['Thu'])) { ?>
                    <li>
                        <p>Thursday:
                            <?php echo date("g:i a", strtotime($untimes['Thu']['mintime']))?> -
                            <?php echo date("g:i a", strtotime($untimes['Thu']['maxtime']))?>
                        </p>
                    </li>
                    <?php } if(isset($untimes['Fri'])) { ?>
                    <li>
                        <p>Friday:
                            <?php echo date("g:i a", strtotime($untimes['Fri']['mintime']))?> -
                            <?php echo date("g:i a", strtotime($untimes['Fri']['maxtime']))?>
                        </p>
                    </li>
                    <?php } if(isset($untimes['Sat'])) { ?>
                    <li>
                        <p>Saturday:
                            <?php echo date("g:i a", strtotime($untimes['Sat']['mintime']))?> -
                            <?php echo date("g:i a", strtotime($untimes['Sat']['maxtime']))?>
                        </p>
                    </li>
                    <?php } if(isset($untimes['Sun'])) { ?>
                    <li>
                        <p>Sunday:
                            <?php echo date("g:i a", strtotime($untimes['Sun']['mintime']))?> -
                            <?php echo date("g:i a", strtotime($untimes['Sun']['maxtime']))?>
                        </p>
                    </li>
                    <?php
                        }
                      }
                  }


//		          if ($result->num_rows > 0) {
//		              // output data of each row
//		              while($row = $result->fetch_assoc()) {
//		                  $today = date("D");
//
//		                  $street = $row["streetname"];
//		                  $street = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($street))));
//
//		                  $string = $row["parking_time"];
//		                  $json = json_decode($string, true);
//
//		                  echo $street. "<br>";
//		                  echo $today. "<br>";
//		                  // print_r($json);
//		                  if (is_array($json)[$today]) {
//		                    foreach ($json[$today] as $t) {
//		                      echo "Start Time:". $t['mintime'] ."\n";
//		                    };
//		                  }
//		              }
//		          } else {
//		              echo "No Results.";
//		          }

		          $con->close();
		          ?>
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
                                new google.translate.TranslateElement({
                                    pageLanguage: 'en',
                                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                                    multilanguagePage: true
                                }, 'google_translate_element');
                            }

                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                </ul>


        </div>

        <div class="col-sm-12 text-center">
            <a href="https://buffaloroam.ppprk.com/park/" target="_blank" class="btn btn-primary mt-4 mb-4">Park with Buffalo Roam &raquo;</a>
        </div>
        <div class="col-sm-12 mt-4 mb-5">
            <h4>Get a text when it's time to move.</h4>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter phone number..." aria-label="Text alerts" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" type="button">Send me Alerts</button>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sorry but this feature isn't ready yet. We're still building. You'll be one of the first to know when it's ready. </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
                    </div>
                    <!--
		      <div class="modal-body">
		        ...
		      </div>
-->
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-primary">Stay tuned!</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-sm-12">
            <p class="notice">The times listed above are the range of time when tickets were given. All calculations have been made using <a href="https://data.buffalony.gov/Transportation/Parking-Summonses/yvvn-sykd" target="_blank">summons data collected during parking violations.</a> Park smarter.</p>
        </div>
    </div>

    <div class="footer">

    </div>
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
            /** @type {!HTMLInputElement} */
            (document.getElementById('autocomplete')), {
                types: ['geocode']
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
