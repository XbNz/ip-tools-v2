<template>
    <div id="map"/>
    <slot/>
</template>


<script>
import mapboxgl from "mapbox-gl";
import "mapbox-gl/dist/mapbox-gl.css";
import { onMounted } from "vue";

export default {
    // Require prop "coordinates" to be passed in
    props: {
        mapboxBuildInfo: {
            type: Array,
        }
    },


    mounted() {
        mapboxgl.accessToken =
            "pk.eyJ1IjoieGJueiIsImEiOiJjbDBweGxsNDUwN25tM2NwNjk0OWI0N3l3In0.q78iWSWl0j_UBJhsNP8BwA";
        const map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/light-v9",
        });

        map.setMaxZoom(8);

        map.on("load", () => {
            map.addSource("coordinates", {
                type: "geojson",
                data: {
                    type: 'FeatureCollection',
                    features:
                        this.mapboxBuildInfo.map(info => {
                            return {
                                type: 'Feature',
                                geometry: {
                                    type: 'Point',
                                    coordinates: info.coordinates
                                },
                                properties: {
                                    ip: info.ip,
                                }
                            };
                        })
                }
            });
            map.addLayer({
                id: 'coordinates',
                type: 'symbol',
                source: 'coordinates',
                layout: {
                    'icon-image': 'marker-15',
                },
            });

            map.on('click', 'coordinates', (e) => {
                const coordinates = e.features[0].geometry.coordinates.slice();
                const ip = e.features[0].properties.ip;

                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(ip)
                    .addTo(map);
            });
        });
    },
};

</script>

<style>
#map {
    height: 100%;
    width: 100%;
}
</style>






