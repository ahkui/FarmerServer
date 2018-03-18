window.map = null
window.markers = null;
window.markerCluster = null;
window.clearMarker = () => {
    if(window.markerCluster)
        if (window.markers != null)
            window.markerCluster.removeMarkers(window.markers)
};
window.generateMarker = (location_data) => {
    if (window.markers != null)
            window.markerCluster.removeMarkers(window.markers)
    window.markers = location_data.map(function(location, index) {
        return new google.maps.Marker({
            position: { lat: parseFloat(location.location.coordinates[1]), lng: parseFloat(location.location.coordinates[0]) },
            label: "" + name + ""
        });
    });
    window.markerCluster = new MarkerClusterer(map, markers, { imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' });
};
window.windowResize = () => {
    var navHeight = Math.floor($('nav').height() + ($('nav').css('padding-bottom').replace('px', '') * 2));
    $('#map').css('top', navHeight + "px");
}

window.map_ready = () => {}
Rx.DOM.click(document.getElementsByClassName("navbar-toggler-icon")).subscribe(windowResize);
Rx.DOM.resize(window).subscribe(windowResize);
Rx.DOM.ready().subscribe(() => {
    console.log("dom ready");
    window.GoogleMaps = require('load-google-maps-api')
    window.MarkerClusterer = require('node-js-marker-clusterer');
    window.initMap();
});

window.initMap = () => {
    GoogleMaps({ key: "AIzaSyAMC2qdXdScCtK9Lzz2zuBMkaGMRtWOQ4k" }).then((googleMaps) => {
        window.map = new googleMaps.Map(document.getElementById('map'), {
            zoom: 12,
            center: { lat: 23.9037, lng: 121.0794 }
        })
        window.cancel = null;
        window.CancelToken = axios.CancelToken;
        map.addListener('zoom_changed', clearMarker);
        map.addListener('dragstart', clearMarker);
        map.addListener('idle', () => {
            if (window.cancel != null)
                window.cancel();
            axios.post('search', map.getBounds().toJSON(), {
                cancelToken: new CancelToken(function executor(c) {
                    window.cancel = c;
                })
            }).then((res) => {
                console.log(res.data)
                generateMarker(res.data)
            }).catch((error) => {});
        });
        windowResize();
    });
};