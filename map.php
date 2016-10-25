<?php  
	echo "<h2>Map of patients</h2>";
    echo "<p>This map provides an overview about the location of your patients</p>";

?>
    <div id="map"></div>
    <script>

	function initMap() {
	  var myLatLng1 = {lat: 59.6567, lng: 16.6709};
	  var myLatLng2 = {lat: 57.3365, lng: 12.5164};

	  var map = new google.maps.Map(document.getElementById('map'), {
	    zoom: 3,
	    center: myLatLng1
	  });

	  var marker1 = new google.maps.Marker({
	    position: myLatLng1,
	    map: map,
	    title: 'patient 1'
	  });

	  var marker2 = new google.maps.Marker({
	    position: myLatLng2,
	    map: map,
	    title: 'patient 2'
	  });
	}

    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCww-TCzeoO3LDSeeVfby8xCR72iyajCvE&signed_in=true&callback=initMap"></script>
