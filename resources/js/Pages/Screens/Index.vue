<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/vue3";

defineProps([
    'screens'
]);

const form = useForm({
    screen: 0,
    amountOfSeats: 0,
    percentageTaken: 0,
    ticketAmount: 0
});

</script>

<template>
    <Head title="Select a Screen"/>
    <div class="max-w-2xl mx-auto mt-10 p-4 sm:p-6 lg:p-8 border border-gray-400 bg-gray-200 rounded-lg">
        <form @submit.prevent="form.post(route('screen.show'))">
            <div>
                <label for="screens" class="block text-sm font-medium leading-6 text-gray-900">Select a screen:</label>
                <select id="screens" v-model="form.screen"  class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option v-for="screen in screens" :key="screen" :value="screen.id">{{ screen.id }}</option>
                </select>
            </div>
            <div class="flex items-center justify-center mt-1">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2 text-gray-500">or</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>
            <div class="mt-1">
                <label for="amountOfSeats" class="block text-sm font-medium leading-6 text-gray-900">Type the number of total seats in the cinema:</label>
                <input id="tickets" v-model="form.amountOfSeats" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>
            <div class="mt-1">
                <label for="percentageTaken" class="block text-sm font-medium leading-6 text-gray-900">Type the percentage of seats that are already taken:</label>
                <input id="tickets" v-model="form.percentageTaken" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>
            <div class="flex items-center justify-center mt-1">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-2 text-gray-500">always</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>
            <div class="mt-1">
                <label for="tickets" class="block text-sm font-medium leading-6 text-gray-900">Type the number of wanted tickets:</label>
                <input id="tickets" v-model="form.ticketAmount" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            </div>
            <primary-button class="mt-4">Find seats</primary-button>
        </form>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        </div>
    </div>
</template>

<style scoped>

</style>
