var top_menu_height = 0;
jQuery(function($) {
    $(document).ready( function() {

            // load google map
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' + 'callback=initialize';
        document.body.appendChild(script);

    });
});

function initialize() {
	var mapOptions = {
	zoom: 15,
	center: new google.maps.LatLng(7.068497999999993,125.60802799999999),
	mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	var image = 'mpci-view/images/mapmarker.png';
	var myLatLng = new google.maps.LatLng(7.068497999999993,125.60802799999999);
	var beachMarker = new google.maps.Marker({
		position: myLatLng,
		map: map,
		icon: image
	});
}
google.maps.event.addDomListener(window, 'load', initialize);