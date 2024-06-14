<script setup>
import {Head, router} from "@inertiajs/vue3";
import { computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    screenId: Number,
    screenCapacity: Number,
    availableSeats: Boolean,
    availableSeatsArray: Array,
    seatNumbersArray: Array
});

// Computed property to create an array based on screen_capacity
const seatArray = computed(() => {
    return Array.from({ length:  props.screenCapacity }, (_, i) => i + 1);
});

// This function takes an array and a size as inputs and splits the array into smaller arrays (chunks) of the specified size.
const chunkArray = (array, size) => {
    const result = [];
    for (let i = 0; i < array.length; i += size) {
        result.push(array.slice(i, i + size));
    }

    return result;
};

// Computed property to chunk the seats array into groups of 10
const chunkedSeats = computed(() => chunkArray(seatArray.value, 5));

// Method to check if a seat is available
const isSeatAvailable = (seat) => {
    return props.availableSeatsArray.includes(seat);
};

const isChosenSeat = (seat) => {
    return props.seatNumbersArray.includes(seat);
}

const labelClass = (seat) => {
    return {
        'text-red-500': !isSeatAvailable(seat),
        'text-green-500': isChosenSeat(seat),
    };
};

</script>

<template>
    <Head title="Shows seats"/>
    <div class="max-w-6xl mx-auto mt-10 p-4 sm:p-6 lg:p-12 border border-gray-400 bg-gray-200 rounded-lg">
        <div>
            <h2 v-if="props.screenId" class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">You have chosen screen number: {{ props.screenId }}</h2>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"></h2>
            <p v-if="!props.availableSeats"> Sorry, there are no seats available anymore. </p>
        </div>
        <div v-if="props.availableSeats">
            <p>
                The recommended seats for this screen are: {{ props.seatNumbersArray }}
            </p>
            <div v-for="(chunk, index) in chunkedSeats" :key="index" class="checkbox-row">
                <div v-for="seat in chunk" :key="seat" class="checkbox-item">
                    <label :class="labelClass(seat)">
                        <input type="checkbox" :value="seat" :disabled="!isSeatAvailable(seat)">
                        {{ seat }}
                    </label>
                </div>
            </div>
        </div>
        <primary-button class="mt-4" @click="router.get('/')">Go back</primary-button>
    </div>
</template>

<style scoped>

.checkbox-row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 10px;
}

.checkbox-item {
    flex: 0 0 15%;
    box-sizing: border-box;
    padding: 5px;
}

</style>
