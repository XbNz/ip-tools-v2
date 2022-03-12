<template>
    <Head>
        <title>Home</title>
    </Head>

    <div class="flex flex-wrap mb-5">
        <div class="w-full">
            <h2 class="text-2xl font-semibold flex justify-center mb-3">Your IP Address</h2>
            <div class="w-full flex sm:border-b sm:border-gray-300 relative flex-col sm:flex-row">
                <div class="flex-1 sm:text-center font-medium pb-3 cursor-pointer hover:text-blue-400 false">
                    Basic
                </div>
                <div class="flex-1 sm:text-center font-medium pb-3 cursor-pointer hover:text-blue-400 false">
                    Advanced
                </div>
                <div class="hidden sm:block absolute bottom-0 left-0 h-1 bg-blue-400 transition-transform duration-300 ease-out w-2/4 transform translate-x-double"></div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">

                <div class="flex flex-wrap mx-3 mb-6">
                    <div class="w-full px-3">
                        <p class="text-gray-700 text-base">
                            Content
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 p-3">
            <h1 class="text-2xl font-bold mb-3">IP Lookup</h1>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="lookupIP">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ip">
                        IP Address
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="ip" type="text" placeholder="IP Address" v-model="ip">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Lookup
                    </button>
                </div>
            </form>
        </div>
        <div class="w-full md:w-1/2 p-3">
            <h1 class="text-2xl font-bold mb-3">AS Lookup</h1>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="lookupAS">
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
import {Head} from '@inertiajs/inertia-vue3'
</script>

