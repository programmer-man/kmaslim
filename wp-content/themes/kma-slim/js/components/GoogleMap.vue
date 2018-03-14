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
            }
        },

        data: function () {
            return {
                mapName: this.name + "-map",
                markers: [],
                config: {},
                map: {}
            }
        },

        mounted() {
            this.config = {
                zoom: this.zoom,
                origin: {}, //we don't know this yet
                mapElement: this.$refs.map,
                destination: {
                    latitude: this.latitude,
                    longitude: this.longitude
                },
                directionsButton: this.$refs.directionsButton,
                directionsPanel: this.$refs.directionsPanel
            };
            this.renderMap();
        },

        methods: {
            renderMap () {
                let vm = this;
                new GoogleMap(vm.config, vm.pins, vm.api)
                  .load()
                  .then(rendered => {
                      this.renderedMap = rendered;
                  });
            },
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