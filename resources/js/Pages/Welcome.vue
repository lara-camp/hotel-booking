<script setup>
    import { Head, router } from '@inertiajs/vue3';
    import { reactive, ref } from 'vue';
    import Calendar from 'primevue/calendar';
    import Button from 'primevue/button';

    defineProps({
        canLogin: {
            type: Boolean,
        },
        canRegister: {
            type: Boolean,
        },
    });

    const filterDate = reactive({
        from_date: "",
        to_date: ""
    })

    const minDate = ref(new Date());

    function filterRooms() {
        router.visit(route('index', {
            _query: {
                from_date: filterDate.from_date,
                to_date: filterDate.to_date
            }
        }))
    }

</script>

<template>
    <Head title="Welcome" />
    <div class="h-[1000rem]  bg-slate-100 rounded p-3">
        <div class="md:max-w-[75rem] max-w-2xl flex-col items-center justify-center mx-auto p-3">
            <div class="my-16">
                <h1 class=" mb-3 text-6xl font-bold">Welcome to Laracamp Hotel</h1>
                <h2 class="text-4xl font-normal">Reserve your room</h2>
            </div>
            <div class="flex">
                <div class=" flex items-baseline mr-3">
                    <label for="checkin" class="mr-3">From</label>
                    <Calendar v-model="filterDate.from_date" :manualInput="true" class="h-full" id="checkin" :minDate="minDate" />
                </div>
                <div class=" flex items-baseline mr-3">
                    <label for="checkin" class="mr-3">To</label>
                    <Calendar v-model="filterDate.to_date" :manualInput="true" class="h-full" id="checkin"
                        :minDate="filterDate.from_date || null" />
                </div>
                <div class="">
                    <Button label="Search" outlined @click="filterRooms"/>
                </div>
            </div>
            <div class="h-96 w-full"></div>
        </div>
    </div>
</template>
<script>
    import IndexLayout from '@/Layouts/IndexLayout.vue';

    export default {
        layout: IndexLayout
    }
</script>

<style scoped></style>