<template>
<!--  Make a login form using Tailwind CSS for styling  -->

    <div class="flex flex-col items-center justify-center h-screen">
        <div class="w-1/2">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email" v-model="email">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Password" v-model="password">
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Sign In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    layout: null,
}
</script>

<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import {Ziggy} from "../../ziggy";

let form = useForm({
    'email': '',
    'password': ''
});

console.log(Ziggy);

let submit = () => {
    form.post(route('auth.login.store'));
}

</script>

<style scoped>

</style>
