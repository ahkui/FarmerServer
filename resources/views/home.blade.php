@extends('layouts.app') @section('content')
<div id="map"></div>
<script>
var locations = [];
var map = null

loadJSON('{{asset('storage/location2.json')}}',
  function(data) {
    locations = data;
    initMarker();
    console.log(locations);

  },
  function(xhr) {
    console.error(xhr);
  }
);

function loadJSON(path, success, error) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        if (success)
          success(JSON.parse(xhr.responseText));
      } else {
        if (error)
          error(xhr);
      }
    }
  };
  xhr.open("GET", path, true);
  xhr.send();
}

function initMap() {

  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8,
    center: { lat: 23.9037, lng: 121.0794 }
  });
}

function initMarker() {
  if (map != null) {
    var markers = locations.map(function(location, index) {
      return new google.maps.Marker({
        position: { lat: parseFloat(location.geometry.location.lat), lng: parseFloat(location.geometry.location.lng) },
        label: "" + index + ""
      });
    });
    var markerCluster = new MarkerClusterer(map, markers, { imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' });
  } else {
    initMap();
  }
}
</script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMC2qdXdScCtK9Lzz2zuBMkaGMRtWOQ4k&callback=initMap"></script>
<script>
function resize_google_map() {
  $('#map').height($(window).height() - $('nav').height())
}
resize_google_map();
$(window).resize(function(event) {
  resize_google_map();
});
</script>
@endsection