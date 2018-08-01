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
         <span class="float-right d-sm-none d-none d-md-inline-block" tabindex="0" data-toggle="tooltip" title="ParkBFLO uses parking violation data to determine when payment is required at a particular parking location. Times are calculated based the earliest and latest times of tickets given on a particular day and are not necessarily a reflection of the actual rules for a specific location.">
         <button class="btn btn-outline-secondary btn-sm" style="pointer-events: none;" type="button" disabled>What am I seeing?</button>
         </span>
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
            
            $fetch = "SELECT * FROM parking_times_v2";
            
            $today = date("D");
            $time = date("H:i a");
            
            $result = $con->query($fetch);
            $add_street = $_POST['add_street'];
            $add_num = $_POST['add_num'];
            $street = strtolower(preg_replace('/\W\w+\s*(\W*)$/', '$1', $add_street));
            $count = 0;
             
            while($row = $result->fetch_assoc()) {
            
            $streetname = strtolower($row['streetname']);
            
            if($street == $streetname ){
                $range = json_decode($row['add_range'],true);
                
                if($add_num < $range['max'] && $add_num > $range['min']){
                    $times = $row['parking_time'];
                    $census_block = $row['census_block'];
                    $untimes = json_decode($times,true);
            
                
            if (isset($untimes[$today])){ 
            if ($time >= date("H:i a", strtotime($untimes[$today]['mintime'])) && $time <= date("H:i a", strtotime($untimes[$today]['maxtime']))) { ?>
         <p class="message">PAY TO PARK</p>
         <?php } else{ ?>
         <p class="message-good">FREE PARKING</p>
         <?php  } ?>
         <?php } elseif(!isset($untimes[$today])) {?>
         <p class="message-good">FREE PARKING</p>
         <?php } ?>
         <p>Census Block:
            <?php echo $census_block;?>
            
         </p>
         <ul>
            <li>
               <p><b>Pay to park between these times:</b></p>
            </li>
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
            <?php } ?>
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
    </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5>Coming Soon</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <p>Sorry but this feature isn't ready yet. We're still building. You'll be one of the first to know when it's ready. </p>
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
      
      
        <?php  
         $count = 1; 
              }  
            }
         };
        ?>
         
         
      <?php if($count == 0){ ?>
      <p>It doesn't look like there are any meters at that location.</p>
      <div class="jumbotron text-center">
         <p class="lead">Search again?</p>
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
      <?php } ?>
   </div>
   <div class="footer">
   </div>
<script>
   $(function() {
       $('[data-toggle="tooltip"]').tooltip()
   })
   
</script>
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