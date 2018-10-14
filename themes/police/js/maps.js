var map;
var markers = [];
var paths = [];
var coords = {
    centre: {lat: null, lng: null},
    start: {lat: null, lng: null},
    end: {lat: null, lng: null}
};

function initMap() {

    var default_coords = {
        lat: 49.212329,
        lng: -2.130775
    };

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                default_coords.lat = position.latitude;
                default_coords.lng = position.longitude;
            }
        );
    }

    // Initiate the map in it's default state
    map = new google.maps.Map(
        document.getElementById('map'),
        {
            zoom: 12,
            center: default_coords
        }
    );

    map.addListener('click', mapClick);

}

var mapClick = function(event) {

    var centralLatField = document.querySelector('.js--central-latitude');
    var centralLat = centralLatField.value;
    var centralLngField = document.querySelector('.js--central-longitude');
    var centralLng = centralLngField.value;
    var startLatField = document.querySelector('.js--start-latitude');
    var startLat = startLatField.value;
    var startLngField = document.querySelector('.js--start-longitude');
    var startLng = startLngField.value;
    var endLatField = document.querySelector('.js--end-latitude');
    var endLat = endLatField.value;
    var endLngField = document.querySelector('.js--end-longitude');
    var endLng = endLngField.value;

    var selected_coords = {
        lat: event.latLng.lat(),
        lng: event.latLng.lng()
    };

    if (!centralLat && !centralLng) {
        // Update the hidden lat/lng field values
        centralLatField.value = selected_coords.lat;
        centralLngField.value = selected_coords.lng;
        // Store in master coords object for later use
        coords.centre.lat = selected_coords.lat;
        coords.centre.lng = selected_coords.lng;
        // Update the read-only central location message
        var description = document.querySelector('.js--describe-central-location');
        description.innerHTML = "";
        var link = document.createElement("a");
        link.className = "remove js--remove-central-location";
        link.href = "#";
        link.title = "Remove Central Location";
        var linkText = document.createTextNode("x");
        link.appendChild(linkText);
        link.addEventListener('click', resetMap);
        description.appendChild(link);
        var descriptionText = document.createTextNode(selected_coords.lat + ', ' + selected_coords.lng);
        description.appendChild(descriptionText);
        // Update the read-only route start message
        document.querySelector('.js--describe-route-start').innerHTML = 'Select start point of affected route on the map';
        // Add a marker to the map
        var marker = new google.maps.Marker({
            position: selected_coords,
            map: map
        });
        // Add central marker to markers array
        markers.push(marker);
        // Enable submit button
        document.querySelector('.js--submit-button').disabled = false;
    } else if (!startLat && !startLng) {
        // Update the hidden lat/lng field values
        startLatField.value = selected_coords.lat;
        startLngField.value = selected_coords.lng;
        // Store in master coords object for later use
        coords.start.lat = selected_coords.lat;
        coords.start.lng = selected_coords.lng;
        // Update the read-only route start message
        document.querySelector('.js--describe-route-start').innerHTML = selected_coords.lat + ', ' + selected_coords.lng;
        // Update the read-only route start message
        document.querySelector('.js--describe-route-end').innerHTML = 'Select end point of affected route on the map';
        // Add a marker to the map
        var marker = new google.maps.Marker({
            position: selected_coords,
            map: map,
            label: 'A'
        });
        markers.push(marker);
    } else if (!endLat && !endLng) {
        // Update the hidden lat/lng field values
        endLatField.value = selected_coords.lat;
        endLngField.value = selected_coords.lng;
        // Store in master coords object for later use
        coords.end.lat = selected_coords.lat;
        coords.end.lng = selected_coords.lng;
        // Update the read-only central location message
        document.querySelector('.js--describe-route-end').innerHTML = selected_coords.lat + ', ' + selected_coords.lng;
        // Add a marker to the map
        var marker = new google.maps.Marker({
            position: selected_coords,
            map: map,
            label: 'B'
        });
        markers.push(marker);
        // Request and plot route
        getDirections();

    } else {
        console.log('Stop clicking!');
    }

}

var getDirections = function() {

    var dirRequest = {
        origin: coords.start,
        destination: coords.end,
        waypoints: [
            {
                location: coords.centre,
                stopover: false
            }
        ],
        travelMode: 'DRIVING'
    }

    // Instantiate a directions service.
    var directionsService = new google.maps.DirectionsService();
    directionsService.route(dirRequest, function(response, status) {

        if (status === 'OK') {

            var route = response.routes[0];
            document.querySelector('.js--route-name').value = route.summary;
            
            // Create base waypoint field for cloning
            var wpField = document.createElement('input');
            wpField.classList = "js--map-data js--route-waypoints";
            wpField.type = "hidden";

            // Define waypoint wrapper element
            var wpWrapper = document.querySelector('.js--waypoints-wrapper');

            var pathWaypoints = [];

            // Loop over all returned waypoints
            for (var i = 0; i < route.overview_path.length; i++) {

                // Build and append waypoint i Lat field
                var wpLatField = wpField.cloneNode(true);
                wpLatField.name = "Route[Waypoints][" + i + "][Latitude]";
                wpLatField.value = route.overview_path[i].lat();
                wpWrapper.appendChild(wpLatField);

                // Build and append waypoint i Lng field
                var wpLngField = wpField.cloneNode(true);
                wpLngField.name = "Route[Waypoints][" + i + "][Longitude]";
                wpLngField.value = route.overview_path[i].lng();
                wpWrapper.appendChild(wpLngField);

                // Store lat/lng in path waypoints arrray
                pathWaypoints.push({lat: route.overview_path[i].lat(), lng: route.overview_path[i].lng()})

            }

            // Add path line
            var closurePath = new google.maps.Polyline({
                path: pathWaypoints,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2
            });
            closurePath.setMap(map);
            paths.push(closurePath);

        } else {
            alert('Oh No! There was an error returned by Google Direction Service - Status:"' + status + '"');
        }

    });
    
}

var resetMap = function(e) {
    e.preventDefault();
    // re-add our descriptions
    document.querySelector('.js--describe-central-location').innerHTML = "Select a location on the map";
    document.querySelector('.js--describe-route-start').innerHTML = "Please select a central point first";
    document.querySelector('.js--describe-route-end').innerHTML = "Please select a start point first";
    // Delete all waypoint fields
    document.querySelector('.js--waypoints-wrapper').innerHTML = "";
    // Clear the map data field values
    var mapDataFields = document.querySelectorAll('.js--map-data');
    for(var i = 0; i < mapDataFields.length; i++) {
        mapDataFields[i].value = "";
    }
    // Reset master coords object
    coords.centre.lat = null;
    coords.centre.lng = null;
    coords.start.lat = null;
    coords.start.lng = null;
    coords.end.lat = null;
    coords.end.lng = null;
    // Remove all markers on the map
    deleteDrawings();
    // Disable the submit button
    document.querySelector('.js--submit-button').disabled = true;
}

// Sets the map on all markers in the array.
var setMapOnAll = function(map) {

    // Delete markers
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }

    // Delete paths
    for (var i = 0; i < paths.length; i++) {
        paths[i].setMap(map);
    }

}

/**
 * Deletes all markers and paths from the map and then empties the global arrays
 * which store them
 */
var deleteDrawings = function() {
    setMapOnAll(null);
    markers = [];
    paths = [];
}
