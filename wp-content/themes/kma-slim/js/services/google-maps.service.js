import GoogleMapsLoader from 'google-maps';

export default class GoogleMap {
    constructor(config, pins, api) {
        this.config = config;
        this.map = {};
        this.apiKey = api;
        this.pins = pins;
    }

    load() {
        return new Promise((resolve, reject = null) => {
            resolve(this.render());
        });
    }

    render() {
        GoogleMapsLoader.KEY = this.apiKey;
        let config = this.config;
        let mapData = this.map;
        GoogleMapsLoader.load(google => {
            mapData.map = new google.maps.Map(config.mapElement, {
                zoom: config.zoom,
                center: new google.maps.LatLng(config.destination.latitude, config.destination.longitude),
                disableDefaultUI: true,
                zoomControl: true,
                scaleControl: true,
                maxZoom: 18
            });
        });

        return mapData;
    }
}