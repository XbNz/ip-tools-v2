<template>
    <Modal
        :closeable="true"
        :show="show"
        max-width="6xl"
    >
        <div class="flex flex-wrap mb-5">
            <div class="w-full mt-2">
                <div class="w-full flex sm:border-b sm:border-gray-300 relative flex-col sm:flex-row">
                    <div class="flex-1 sm:text-center font-medium pb-3 cursor-pointer hover:text-blue-400 false"
                         @click="tabModes.basic()">
                        Basic
                    </div>

                    <div class="flex-1 sm:text-center font-medium pb-3 cursor-pointer hover:text-blue-400 false"
                         @click="tabModes.advanced()">
                        Advanced
                    </div>

                    <div
                        class="hidden sm:block absolute bottom-0 h-1.5 bg-blue-400 transition-transform duration-300 ease-out w-2/4 transform translate-x-double"
                        :class="{'left-0' : tabMode === 'basic', 'right-0' : tabMode === 'advanced'}"></div>
                </div>


                <div class="flex flex-wrap mb-3 p-3 rounded-lg" v-if="tabMode === 'basic'">
                    <div class="ml-3">
                        <h1 class="justify-center flex mb-3 font-bold">API provider</h1>
                        <div class="bg-white rounded-lg shadow-lg p-3 outline outline-amber-600">
                            <div v-for="guaranteedData in props.ipAddressInfo.basic.data[0]">
                                <p>{{ guaranteedData.driver }}</p>
                                <div
                                    class="flex mb-3 w-12 h-7 items-center bg-gray-300 rounded-full p-1">
                                    <button
                                        class="bg-white w-6 h-6 rounded-full shadow-md transform duration-300 ease-in-out"
                                        :class="{'translate-x-6': guaranteedData.driver === activeApiProvider.driver}"
                                        @click="activeApiProvider = guaranteedData"
                                    />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="w-5/12 ml-3">
                        <h1 class="justify-center flex mb-3 font-bold">Info</h1>
                        <div class="bg-white rounded-lg shadow-lg p-3 outline outline-amber-600">
                            <div class="flex">
                                <h2 class="font-bold">IP address: &nbsp;</h2>
                                <p>{{ activeApiProvider.ip }}</p>
                            </div>
                            <div class="flex">
                                <h2 class="font-bold">API provider: &nbsp;</h2>
                                <p>{{ activeApiProvider.driver }}</p>
                            </div>
                            <div class="flex">
                                <h2 class="font-bold">Country: &nbsp;</h2>
                                <p>{{ activeApiProvider.country }}</p>
                            </div>
                            <div class="flex">
                                <h2 class="font-bold">City: &nbsp;</h2>
                                <p>{{ activeApiProvider.city }}</p>
                            </div>
                            <div class="flex">
                                <h2 class="font-bold">Latitude: &nbsp;</h2>
                                <p>{{ activeApiProvider.latitude }}</p>
                            </div>
                            <div class="flex">
                                <h2 class="font-bold">Latitude: &nbsp;</h2>
                                <p>{{ activeApiProvider.longitude }}</p>
                            </div>
                        </div>
                    </div>

                    <div id="map-modal" class="w-4/12 ml-10 mt-4 p-4"/>

                    <Mapbox :key="activeApiProvider" :mapboxBuildInfo="[{
                        ip: activeApiProvider.ip,
                        coordinates: [activeApiProvider.longitude, activeApiProvider.latitude]
                    }]" bind-to="map-modal"/>
                </div>


                <div class="mb-3 p-3" v-if="tabMode === 'advanced'">
                    <div class="flex">
                        <div class="ml-3">
                            <h1 class="justify-center flex mb-3 font-bold">API provider</h1>
                            <div class="bg-white rounded-lg shadow-lg p-3 outline outline-amber-600">
                                <div v-for="advancedData in props.ipAddressInfo.advanced.data[0]">
                                    <p>{{ advancedData.driver }}</p>
                                    <div
                                        class="flex mb-3 w-12 h-7 items-center bg-gray-300 rounded-full p-1">
                                        <button
                                            class="bg-white w-6 h-6 rounded-full shadow-md transform duration-300 ease-in-out"
                                            :class="{'translate-x-6': advancedData.driver === activeAdvancedApiProvider.driver}"
                                            @click="activeAdvancedApiProvider = advancedData"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-10/12 ml-3">
                            <h1 class="justify-center flex mb-3 font-bold">Info</h1>
                            <div class="bg-white rounded-lg shadow-lg p-3 outline outline-amber-600">
                                <div class="flex">
                                    <pre>{{ activeAdvancedApiProvider.data }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <slot/>
    </Modal>

</template>

<script setup>

import Modal from "./Modal";
import {ref, watch} from "vue";
import Mapbox from "./Mapbox";

let props = defineProps({
    ipAddressInfo: {
        type: Object,
        required: true,
    },
    show: {
        type: Boolean,
        required: true,
    },
})


let tabModes = {
    'basic': () => {
        tabMode.value = 'basic';
    },
    'advanced': () => {
        tabMode.value = 'advanced';
    },
}


let activeApiProvider = ref()
let activeAdvancedApiProvider = ref()

watch(props.ipAddressInfo, (newVal, oldVal) => {

    if (newVal.basic) {
        activeApiProvider.value = newVal.basic['data'][0][Math.floor(Math.random() * Object.keys(newVal.basic['data'][0]).length)];
    }

    if (newVal.advanced) {
        activeAdvancedApiProvider.value = newVal.advanced['data'][0][Math.floor(Math.random() * Object.keys(newVal.advanced['data'][0]).length)];
    }

})



let tabMode = ref('basic');

</script>

