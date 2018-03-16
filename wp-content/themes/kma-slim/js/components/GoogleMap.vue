<template>
    <div>
        <div class="full-width-map">
            <div class="google-map" ref="map" :id="mapName">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import GoogleMap from '../services/google-maps.service.js';
    import axios from 'axios';

    export default {
        props: {
            name: {
                type: String,
                default: this.name
            },
            latitude: {
                type: Number,
                default: this.latitude
            },
            longitude: {
                type: Number,
                default: this.longitude
            },
            zoom: {
                type: Number,
                default: this.zoom
            },
            api: {
                type: String,
                default: 'AIzaSyCRXeRhZCIYcKhtc-rfHCejAJsEW9rYtt4'
            },
            endPoint: {
                type: String,
                default: 'https://mothership.kerigan.com/api/v1/allMapListings'
            }
        },

        data: function () {
            return {
                mapName: this.name + "-map",
                config: {},
                errors: []
            }
        },

        mounted() {
            this.config = {
                zoom: this.zoom,
                mapElement: this.$refs.map,
                center: {
                    latitude: this.latitude,
                    longitude: this.longitude
                },
                markers: []
            };
            this.getMarkers();
        },

        methods: {
            renderMap () {
                let vm = this;
                const map = new GoogleMap(vm.config, vm.api)
                  .load()
                  .then(rendered => {
                      this.renderedMap = rendered;
                  })
                  .catch(e => {
                      this.errors.push(e)
                  })
            },

            getMarkers () {
                axios.get(this.endPoint)
                  .then(response => {
                      this.config.markers = response.data
                      this.renderMap();
                  })
                  .catch(e => {
                      this.errors.push(e)
                  })
            }

        }

    }
</script>
<style>
    .full-width-map,
    .google-map {
        height: 100vh;
        width:100%;
    }
</style>