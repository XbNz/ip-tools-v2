<template>
    <Head>
        <title>Manage subscription</title>
    </Head>

    <div class="flex justify-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" @click="checkout">
            Checkout
        </button>
    </div>
</template>


<script setup>

let props = defineProps({
    'stripeKey': {
        type: String,
        required: true
    },
    'checkoutSessionId': {
        type: String,
        required: true
    }
});

// create a checkout method that will be called when the button is clicked
function checkout() {
    window.Stripe(props.stripeKey).redirectToCheckout({
        sessionId: props.checkoutSessionId
    });
}

</script>
