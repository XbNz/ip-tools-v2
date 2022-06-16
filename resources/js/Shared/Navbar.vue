<template>
    <nav>
        <ul class="flex space-x-6">
            <li>
                <Navlink :href="route('home.index')" :active="$page.component === 'Home'">
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <p class="ml-1">Home</p>
                    </span>
                </Navlink>
            </li>
            <li>
                <Navlink href="" :active="$page.component === 'Ip'">
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="ml-1">Bulk IP Lookup</p>
                    </span>
                </Navlink>
            </li>
            <li>
                <Navlink href="" :active="$page.component === 'Asn'">
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="ml-1">ASN</p>
                    </span>
                </Navlink>
            </li>



            <li v-if="$page.props.authenticated === false">
                <Navlink :href="route('auth.register.create')" method="GET">
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
</svg>
                        <p class="ml-1">Register</p>
                    </span>
                </Navlink>
            </li>

            <li v-if="$page.props.authenticated === true">
                <Navlink :href="route('auth.login.create')" method="GET">
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
</svg>
                        <p class="ml-1">Uptime Monitoring</p>
                    </span>
                </Navlink>
            </li>

            <li v-if="$page.props.authenticated === false">
                <Navlink :href="route('auth.login.create')" method="GET">
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
</svg>
                        <p class="ml-1">Login</p>
                    </span>
                </Navlink>
            </li>

            <li v-if="$page.props.authenticated === true">
                <Navlink :href="route('auth.login.destroy')" method="POST">
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round"
        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
</svg>
                        <p class="ml-1">Logout</p>
                    </span>
                </Navlink>
            </li>
        </ul>
    </nav>
</template>

<script>
import Navlink from "./Navlink";

export default {
    name: "Navbar",
    components: {Navlink}
}
</script>

<style scoped>

</style>
