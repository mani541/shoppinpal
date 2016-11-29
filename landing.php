<?php require_once 'templates/header.php';?>
    <script>
      var map;
      var infowindow;
	  var service;
	  var pos;
      function initMap() {
	    map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 15
        });
		if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(function(position) {
				pos = {
				  lat: position.coords.latitude,
				  lng: position.coords.longitude
				};
				map.setCenter(pos);
				infowindow = new google.maps.InfoWindow();
				service = new google.maps.places.PlacesService(map);
				service.nearbySearch({
					location: pos,
					radius: $("#showrange").val(),
					type: ['restaurant'],
				}, callback);
				var service2 = new google.maps.places.PlacesService(map);
				service2.nearbySearch({
					location: pos,
					radius: $("#showrange").val(),
					type: ['movie_theater'],
				}, callback);
		    },function() {
				pos = {lat: 17.3850, lng: 78.4867};
				map.setCenter(pos);
				alert('error getting location. Please check the location settings/enable the location.');
            });
		}else{
			pos = {lat: 17.3850, lng: 78.4867};
			map.setCenter(pos);
			alert('Geolocation not supported');
		}
      }
      function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }
      function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name);
          infowindow.open(map, this);
        });
      }
	  function changerange(range){
	  $('#showrange').val(range);
	  initMap();
	  }
    </script>
  </head>
    <div class="container">
	    <div class="rangemain">
			<input type="range" id="rangeInput" name="rangeInput" step="50" min="500" max="20000" value="0"  onchange="changerange(this.value);">                                                       
			<output name="amount" id="showrange" for="rangeInput" class="showrange">500</output>
		</div>
		<div id="map" class="map-container"></div>
	</div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9EdKf1drQth_zE38w5m_aqPlh9c_Sng4&libraries=places&callback=initMap" async defer></script>
  </body>
<?php require_once 'templates/footer.php';?>
