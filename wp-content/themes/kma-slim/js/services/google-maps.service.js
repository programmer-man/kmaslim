import GoogleMapsLoader from 'google-maps'
import MarkerClusterer from 'marker-clusterer-plus'

export default class GoogleMap {
    constructor (config, api) {
        this.config = config
        this.map = {}
        this.apiKey = api
        this.visibleMarkers = []
        this.google = {}
        this.markerShape = {
            path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
            scale: .7,
            strokeWeight: 2,
            strokeColor: '#FFF',
            strokeOpacity: .5,
            fillColor: '#555',
            fillOpacity: 1,
            rotation: 0
        }
        this.selectedShape = {
            path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
            scale: .7,
            strokeWeight: 4,
            strokeColor: '#55ff00',
            strokeOpacity: .5,
            fillColor: '#555',
            fillOpacity: 1,
            rotation: 0
        };
    }

    load () {
        return new Promise((resolve, reject = null) => {
            resolve(this.init())
        })
    }

    init () {
        GoogleMapsLoader.KEY = this.apiKey
        GoogleMapsLoader.load(google => {
            this.renderMap(google)
            this.addMarkers(google)
        })
    }

    renderMap (google) {
        let config = this.config
        let mapData = this.map

        mapData.map = new google.maps.Map(config.mapElement, {
            zoom: config.zoom,
            center: new google.maps.LatLng(config.center.latitude, config.center.longitude),
            disableDefaultUI: true,
            zoomControl: true,
            scaleControl: true,
            maxZoom: 20
        })

        mapData.markerClusterer = new MarkerClusterer(
          mapData.map,
          this.visibleMarkers,
        )

        return mapData
    }

    addMarkers (google) {
        let mapData = this.map
        let instance = this;

        google.maps.event.addListener(mapData.map, 'idle', function () {
            instance.drawMarkers(google);
        })
    }

    drawMarkers (google) {
        this.visibleMarkers = [];
        let instance = this;
        let markers = this.config.markers;
        let mapData = this.map;
        let visibleMarkers = this.visibleMarkers;
        let bounds = mapData.map.getBounds();

        for (let i = 0; i < markers.length; i++) {

            let latLng = new google.maps.LatLng(markers[i].latitude, markers[i].longitude)
            if (bounds.contains(latLng)) {
                let marker = new google.maps.Marker({
                    position: latLng,
                    map: mapData.map,
                    draggable: false,
                    flat: true,
                    icon: instance.markerShape
            })
                visibleMarkers.push(marker)

                marker.addListener('click', function () {
                    instance.resetIcons(visibleMarkers);
                    mapData.selected = markers[i];
                    this.setIcon(instance.selectedShape);
                    window.dispatchEvent(new CustomEvent('marker_updated', {
                        detail: markers[i]
                    }));
                });
            }

        }
        if (mapData.markerClusterer) {
            mapData.markerClusterer.clearMarkers()
            mapData.markerClusterer.addMarkers(visibleMarkers)
        }
    }

    resetIcons(markers) {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setIcon(this.markerShape);
        }
    }
}