/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));


Rx.DOM.ready().subscribe(() => {
    console.log("dom ready")
    const app = new Vue({
        el: '#app'
    });
    resize_google_map();
});


var locations = [];
var map = null

loadJSON('http://140.134.26.64:8888/storage/location.json',
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

function resize_google_map() {
    $('#map').height($(window).height() - $('nav').height())
}
$(window).resize(function(event) {
    resize_google_map();
});

window.initMap = initMap;