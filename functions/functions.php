<?php 
function geocoder(){
    global $connection;
    $address = $_POST['address'];
    $address = mysqli_real_escape_string($connection, $address);
    $encodeAdd = urlencode($address);

    $apikey = "AIzaSyD1hgyqHWtrkaolwztdX5G_nc2nFdFgyis"; 
    $geourl = "https://maps.googleapis.com/maps/api/geocode/xml?address=$encodeAdd,+Buffalo,+NY&key=$apikey"; 

    /* Create cUrl object to grab XML content using $geourl */ 
    $c = curl_init(); 
    curl_setopt($c, CURLOPT_URL, $geourl); 
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
    $xmlContent = trim(curl_exec($c)); 
    curl_close($c); 
    /* Create SimpleXML object from XML Content*/
    $xmlObject = simplexml_load_string($xmlContent); 
    /* Print out all of the XML Object*/ 
    $localObject = $xmlObject->result->geometry->location; 

    $lng = ($localObject->lng);
    $lat = ($localObject->lat);
    return array($address, $lng, $lat);
}

function createRows(){
    global $connection;
    if(isset($_POST['submit'])){

        $name = $_POST['name'];
        $type = $_POST['type'];
        
        $array = geocoder();
        $address = $array[0];
        $lng = $array[1];
        $lat = $array[2];
        
        $name = mysqli_real_escape_string($connection, $name);
        $type = mysqli_real_escape_string($connection, $type);
        
        $query = "INSERT INTO markers(name, address, lng, lat, type)";
        $query .= " VALUES ('$name', '$address', '$lng', '$lat', '$type')"; 

        $result = mysqli_query($connection, $query);

        if(!$result){
            die('Query failed.' . mysqli_error($connection));
        } else{
            echo "Record created!";
        }
    }
}
?>