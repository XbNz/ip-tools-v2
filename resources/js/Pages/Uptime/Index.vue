<template>
    <Head>
        <title>Uptime</title>
    </Head>

    <div class="w-5/6 mx-auto">
        <div class="w-full shadow-2xl subpixel-antialiased rounded h-64 bg-black border-black mx-auto">
            <div class="flex items-center h-6 rounded-t bg-gray-100 border-b border-gray-500 text-center text-black" id="headerTerminal">
                <div class="flex ml-2 items-center text-center border-red-900 bg-red-500 shadow-inner rounded-full w-3 h-3" id="closebtn">
                </div>
                <div class="ml-2 border-yellow-900 bg-yellow-500 shadow-inner rounded-full w-3 h-3" id="minbtn">
                </div>
                <div class="ml-2 border-green-900 bg-green-500 shadow-inner rounded-full w-3 h-3" id="maxbtn">
                </div>
                <div class="mx-auto pr-16" id="terminaltitle">
                    <p class="text-center text-sm">Uptime monitoring tools</p>
                </div>

            </div>
            <div class="pl-1 pt-1 h-auto  text-green-200 font-mono text-xs bg-black" id="console">
                <p class="pb-1">ping example.com --notifications="on" --email="alert@gmail.com" </p>
                <p class="pb-1">ping example.com -c 10</p>
                <p class="pb-1">mtr example.com -c 10</p>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        <div class="bg-cyan-100 max-w-sm rounded overflow-hidden shadow-lg p-5 mt-4">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">Health check</div>
                <p class="text-gray-700 text-base">
                    Create a health check for an IPv4 or IPv6 host
                </p>
            </div>

            <div class="flex justify-center">
                <button class="flex justify-center w-2/6 bg-blue-500 hover:bg-red-100 text-white font-bold py-2 px-4 rounded-full">
                    <a :href="route('auth.login.create')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-11 w-11 hover:fill-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                </button>

            </div>

        </div>
    </div>

    <div class="flex justify-center">
        <div class="bg-blue-300 max-w-sm rounded overflow-hidden shadow-lg p-5 mt-4">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">Run ping</div>
                <p class="text-gray-700 text-base">
                    One-time ping test for an IPv4 or IPv6 host
                </p>
            </div>

            <div class="flex justify-center">
                <button class="flex justify-center w-2/6 bg-red-700 hover:bg-red-100 text-white font-bold py-2 px-4 rounded-full">
                    <a :href="route('uptime.ping.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-11 w-11 hover:fill-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </a>
                </button>
            </div>

        </div>
    </div>

    <div class="flex justify-center">
        <div class="bg-red-600 max-w-sm rounded overflow-hidden shadow-lg p-5 mt-4">
            <div class="px-6 py-4">
                <div class="font-bold text-white text-xl mb-2">Run MTR</div>
                <p class="text-white text-base">
                    One-time MTR test for an IPv4 or IPv6 host
                </p>
            </div>

            <div class="flex justify-center">
                <button class="flex justify-center w-2/6 bg-red-700 hover:bg-red-100 text-white font-bold py-2 px-4 rounded-full">
                    <a :href="route('auth.login.create')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-11 w-11 hover:fill-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </a>
                </button>
            </div>

        </div>
    </div>

</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
export default {
    name: "Index"
}
</script>

<style scoped>

</style>
