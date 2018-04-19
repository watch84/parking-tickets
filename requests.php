<?php include "inc/header.php"?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 max-height px-0">
            <div id="map"></div>
            <div class='map-overlay'>
                <div id='markers'></div>
            </div>

            <script>
                mapboxgl.accessToken = 'pk.eyJ1IjoiamJodXRjaCIsImEiOiJjamRqZGU1eTYxMTZlMzNvMjV2dGxzdG8wIn0.IAAk5wKeLXOUaQ4QYF3sEA';
                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v10',
                    center: [-78.87, 42.91],
                    zoom: 12.
                });

                map.on('load', function() {

                    map.addLayer(
                        <?php searches();?>
                    );

                    var popup = new mapboxgl.Popup({
                        closeButton: false,
                        closeOnClick: false
                    });


                    // When a click event occurs on a feature in the places layer, open a popup at the
                    // location of the feature, with description HTML from its properties.
                    map.on('click', 'points', function(e) {
                        var coordinates = e.features[0].geometry.coordinates.slice();
                        var num = e.features[0].properties.add_num;
                        var streetname = e.features[0].properties.add_street;

                        // Ensure that if the map is zoomed out such that multiple
                        // copies of the feature are visible, the popup appears
                        // over the copy being pointed to.
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }

                        new mapboxgl.Popup()
                            .setLngLat(coordinates)
                            .setHTML(num + " " + streetname)
                            .addTo(map);
                    });

                    // Change the cursor to a pointer when the mouse is over the places layer.
                    map.on('mouseenter', 'points', function() {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    // Change it back to a pointer when it leaves.
                    map.on('mouseleave', 'points', function() {
                        map.getCanvas().style.cursor = '';
                    });
                });

            </script>
        </div>
    </div>
</div>
