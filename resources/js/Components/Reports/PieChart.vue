<script setup>
import {computed, onMounted, ref} from 'vue';

import {Chart} from "chart.js/auto";

const props = defineProps({
    data: Array,
    label: String,
    name: String,
    id_name: String
});

let recarga = 1;
const graph = ref(null);

onMounted(() => {
    recarga = computed(() => {

        if (graph.value !== null) {
            graph.value.destroy();
        }
        const ctx = document.getElementById(props.id_name);
        const data = {
            labels: props.data.map(row => row.label),
            datasets: [{
                label: props.label,
                data: props.data.map(row => row.value),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75,192,98,0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(201, 203, 207, 0.8)',
                    'rgba(50, 50, 50, 0.8)',
                    'rgba(15,248,229,0.8)',
                    'rgba(46,238,82,0.8)'
                ],
                hoverOffset: 4
            }]
        };

        graph.value = new Chart(ctx, {
            type: 'pie',
            data: data,
            plugins: [{
                id: "bgColor",
                beforeDraw: (chart, options) => {
                    const {ctx, width, height} = chart;
                    ctx.fillStyle = "white";
                    ctx.fillRect(0, 0, width, height);
                    ctx.restore();
                }
            }]
        });
        return 2;
    })
});
</script>

<template>
    <div class="reportItem">
        <input type="hidden" :value="recarga">
        <h2 v-if="data.length > 0" style="text-align: center">{{label}}</h2>
        <canvas :id="props.id_name"></canvas>
    </div>
</template>
