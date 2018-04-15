<?php 
include "db/db.php";

function geocoder(){
    global $con;
    $add_num = $_POST['add_num'];
    $add_street = $_POST['add_street'];
    $address = $add_num . " " . $add_street;
    $address = mysqli_real_escape_string($con, $address);
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
    return array($add_num, $add_street, $lng, $lat);
}

function createRows(){
    global $con;
    if(isset($_POST['submit'])){

        
        $geo_array = geocoder();
        $add_num = $geo_array[0];
        $add_street = $geo_array[1];
        $lng = $geo_array[2];
        $lat = $geo_array[3];
        $zip = $_POST['zip'];
        
        date_default_timezone_set("America/New_York");
        $date = date("Y-m-d h:i:sa");
        
        
        $query = "INSERT INTO searches(add_num, add_street, zip, lng, lat, date)";
        $query .= " VALUES ('$add_num', '$add_street', $zip, '$lng', '$lat', '$date')"; 

        $result = mysqli_query($con, $query);

        if(!$result){
            die('Query failed.' . mysqli_error($con));
        } else{
            echo "Record created!";
        }
    }
}


function searches(){
    // Opens a connection to a MySQL server
    global $con;
    // Select all the rows in the markers table
    $query = "SELECT * FROM searches";
    $result = mysqli_query($con, $query);
    if (!$result) {
      die('Invalid query: ' . mysqli_error());
    }

    $previous = 0;
    $allMarkers = array();


    $coords = array();
    while ($row = mysqli_fetch_assoc($result)){

        $current = $row['id'];

        // We've switched to a new route, output the set of coords
        if ($current > $previous){
            $marker = array(
                'type' => 'Feature',
                'properties' => array(
                    'add_num' => $row['add_num'],
                    'add_street' => $row['add_street'],
//                    'req_type' => $row['req_type']
                ),
                'geometry' => array(
                    'type' => 'Point',
                    'coordinates' => array($row['lng'], $row['lat'])
                )
            );
            array_push($allMarkers, $marker);
            $coords = array();
        } 
        
        $previous = $current;
    };

    
    // Did we have a set of coords left over from the last row?

    $allPoints = array(
        'id' => 'points',
        'type' => 'circle',
        'source' => array(
            'type' => 'geojson',
            'data' => array(
                'type' => 'FeatureCollection',
                'features' => $allMarkers
            )
        ),
        'paint' => array(
            'circle-radius' => 4,
            'circle-color' => "#004e83",
            'circle-stroke-color' => "#004e83",
            'circle-stroke-opacity' => 0.2,
            'circle-stroke-width'=> 8,
        )
    );
    
    echo json_encode($allPoints, JSON_PRETTY_PRINT);
};

//searches();
?>