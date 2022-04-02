<template>
    <Head>
        <title>Home</title>
    </Head>

    <div class="flex flex-wrap mb-5">
        <div class="w-full">
            <h2 class="text-2xl font-semibold flex justify-center mb-3">Your IP Address</h2>
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

            <div class="bg-white rounded-lg shadow-lg p-3">
                <div class="flex flex-wrap mb-3" v-if="tabMode === 'basic'">
                    <div class="ml-3">
                        <h1 class="justify-center flex mb-3 font-bold">API provider</h1>
                        <div class="bg-white rounded-lg shadow-lg p-3 outline outline-amber-600">
                            <div v-for="guaranteedData in props.guaranteedClientIpData">
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

                    <div id="map-home" class="w-4/12 ml-10 mt-4 p-4">
                    </div>

                    <Mapbox :key="activeApiProvider" :mapboxBuildInfo="[{
                            ip: activeApiProvider.ip,
                            coordinates: [activeApiProvider.longitude, activeApiProvider.latitude]
                        }]" bind-to="map-home"/>
                </div>


                <div class="mb-3" v-if="tabMode === 'advanced'">
                    <div class="flex">
                        <div class="ml-3">
                            <h1 class="justify-center flex mb-3 font-bold">API provider</h1>
                            <div class="bg-white rounded-lg shadow-lg p-3 outline outline-amber-600">
                                <div v-for="advancedData in props.advancedClientIpData">
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
    </div>



    <IpLookupModal :show="ipLookupResultsReady" :ip-address-info="ipLookupData">
        <div class="fixed top-0 left-0 mr-4 mb-4">
            <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent" @click="closeModals">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
            </button>
        </div>
    </IpLookupModal>

    <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 p-3">
            <h1 class="text-2xl font-bold mb-3">IP Lookup</h1>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="ipLookupApi">
                <div v-if="ipLookupErrors" class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 mb-2" role="alert">
                    <p> {{ ipLookupErrors }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ip">
                        IP Address
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="ip" type="text" placeholder="IP Address" v-model="ipLookupField">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit"
                    >
                        Lookup
                    </button>
                </div>
            </form>
        </div>
        <div class="w-full md:w-1/2 p-3">
            <h1 class="text-2xl font-bold mb-3">AS Lookup</h1>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="as">
                        AS Number
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="as" type="text" placeholder="AS Number" v-model="as">
                </div>
                <div>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Lookup
                    </button>
                </div>
            </form>
        </div>
    </div>


</template>

<script setup>
import {Head, useForm} from '@inertiajs/inertia-vue3'
import {ref, watch} from "vue";
import {debounce} from "lodash";
import Mapbox from "../Shared/Mapbox";
import IpLookupModal from "../Shared/IpLookupModal";
import axios from "axios";



let props = defineProps({
    guaranteedClientIpData: Array,
    advancedClientIpData: Array,
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModals();
    }
});

const ipLookup = ref(false);
const asLookup = ref(false);

const ipLookupField = ref('');
const asLookupField = ref('');

const ipLookupData = ref({});
const asLookupData = ref({});

const ipLookupResultsReady = ref(false);

const ipLookupErrors = ref();
const asLookupErrors = ref();


const ipLookupForm = useForm({
    ip_addresses: [],
});
const asLookupForm = useForm({
    as_numbers: [],
});


const closeModals = () => {
    ipLookupResultsReady.value = false;
};

const ipLookupApi = () => {
    closeModals();

    ipLookupForm.ip_addresses = ipLookupField.value.split(',').map(ip => ip.trim());
    ipLookupForm.ip_addresses.splice(1);

    axios.post(route('ip.show', ipLookupForm))
        .then(response => {
            ipLookupData.value.basic = response.data;
            ipLookupResultsReady.value = true;
        })
        .catch(error => {
            ipLookupErrors.value = error.response.data.message;
            ipLookupResultsReady.value = false;
            console.log(error);
        });

    axios.post(route('ip.advanced.show', ipLookupForm))
        .then(response => {
            ipLookupData.value.advanced = response.data;
            ipLookupResultsReady.value = true;
        })
        .catch(error => {
            ipLookupErrors.value = error.response.data.message;
            ipLookupResultsReady.value = false;
        });
};

// const asLookupApi = () => {
//     asLookupField.ipAddresses = asLookupField.value.split(',').map(as => as.trim());
//
//     ipLookupData.value = ipLookupForm.post(route('ip.show'), {
//         preserveScroll: true,
//         onFinish: () => ipLookupForm.reset(),
//     });
// };


let tabMode = ref('basic');

let activeApiProvider = ref(
    props.guaranteedClientIpData[Math.floor(Math.random() * props.guaranteedClientIpData.length)]
)

let activeAdvancedApiProvider = ref(
    props.advancedClientIpData[Math.floor(Math.random() * props.guaranteedClientIpData.length)]
)


let tabModes = {
    'basic': () => {
        tabMode.value = 'basic';
    },
    'advanced': () => {
        tabMode.value = 'advanced';
    },
}


</script>

