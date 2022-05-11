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

            <li>
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
