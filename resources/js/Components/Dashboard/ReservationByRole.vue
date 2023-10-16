<template>
    <div class="">
      <h1 class="mb-6 text-2xl font-semibold">Reservation By Role</h1>
      <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full" />
    </div>
  </template>

  <script setup>
    import Chart from "primevue/chart"
    import { ref, onMounted, computed } from "vue"

    const props = defineProps({
      reservationByRole: Object
    })

    const mutatedAvailableRoomTypes = computed(() => ({ labels: Object.keys(props.reservationByRole), data: Object.values(props.reservationByRole) }))

    const chartData = ref({});
    const chartOptions = ref({
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            usePointStyle: true,
          }
        }
      }
    });

    onMounted(() => {
      chartData.value = setChartData();
    });

    const setChartData = () => {
      const documentStyle = getComputedStyle(document.body);

      return {
        labels: mutatedAvailableRoomTypes.value.labels,
        datasets: [
          {
            data: mutatedAvailableRoomTypes.value.data,
            backgroundColor: [documentStyle.getPropertyValue('--blue-500'), documentStyle.getPropertyValue('--yellow-500'), documentStyle.getPropertyValue('--green-500'), documentStyle.getPropertyValue('--red-500'), documentStyle.getPropertyValue('--gray-500')],
            hoverBackgroundColor: [documentStyle.getPropertyValue('--blue-400'), documentStyle.getPropertyValue('--yellow-400'), documentStyle.getPropertyValue('--green-400'), documentStyle.getPropertyValue('--red-400'), documentStyle.getPropertyValue('--gray-400')]
          }
        ]
      };
    };
  </script>

  <style lang="scss" scoped></style>
