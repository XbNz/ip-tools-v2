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

                    <div class="w-4/12 ml-3">
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

                    <div class="w-6/12 mt-4 p-4 rounded-full">
                        <Mapbox :key="activeApiProvider" :mapboxBuildInfo="[{
                            ip: activeApiProvider.ip,
                            coordinates: [activeApiProvider.longitude, activeApiProvider.latitude]
                        }]"/>
                    </div>
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


    <IpLookupModal :show="ipLookup">

    </IpLookupModal>

    <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 p-3">
            <h1 class="text-2xl font-bold mb-3">IP Lookup</h1>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="ipLookupApi">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ip">
                        IP Address
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="ip" type="text" placeholder="IP Address" v-model="ipLookupForm.ipAddresses">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        :disabled="ipLookupForm.processing"
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


let props = defineProps({
    guaranteedClientIpData: Array,
    advancedClientIpData: Array,
});

const ipLookup = ref(false);
const asLookup = ref(false);

const ipLookupData = ref([]);
const asLookupData = ref([]);


const ipLookupForm = useForm({
    ipAddresses: [],
});
const asLookupForm = useForm({
    asNumbers: [],
});


watch(ipLookupData, () => {
    ipLookup.value = true;
});
watch(asLookupData, () => {
    asLookup.value = true;
});


const closeModals = () => {
    ipLookup.value = false;
    asLookup.value = false;

    ipLookupForm.reset();
    asLookupForm.reset();
};

const ipLookupApi = () => {
    ipLookupData.value = ipLookupForm.post(route('ip.show'), {
        preserveScroll: true,
        onFinish: () => ipLookupForm.reset(),
    });

    // TODO: Comma-separate the IP addresses and send them as an array (watch maybe?)
};


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

