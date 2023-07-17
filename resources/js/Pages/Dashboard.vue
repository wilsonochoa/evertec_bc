<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import PieChart from "@/Components/Reports/PieChart.vue";
import BarChart from "@/Components/Reports/BarChart.vue";
import {ref} from "vue";
import {jsPDF} from "jspdf";

const bestProductsChart = ref([]);
const bestCategoriesChart = ref([]);
const desiredProductsChart = ref([]);
const bestCustomersChart = ref([]);
const ordersStatusChart = ref([]);
const paymentsStatusChart = ref([]);

const startDate = ref("");
const endDate = ref("");
const data = ref([]);

const getDataReports = () => {
    axios
        .post(
            route("api.reports"), {
                'startDate': startDate.value,
                'endDate': endDate.value,
            }
        )
        .then((response) => {
            bestProductsChart.value = response.data.data.best_products;
            bestCategoriesChart.value = response.data.data.best_categories;
            desiredProductsChart.value = response.data.data.desired_products;
            bestCustomersChart.value = response.data.data.best_customers;
            ordersStatusChart.value = response.data.data.orders_status;
            paymentsStatusChart.value = response.data.data.payments_status;
        })
        .catch((error) => {
            console.log(error);
        });
};

const pdf = () => {
    const doc = new jsPDF();
    doc.setFontSize(20);

    doc.text("10 Productos más vendidos", 10, 10,);
    let canvas1 = document.querySelector('#best_products');
    let img1 = canvas1.toDataURL("image/jpeg", 1.0);
    doc.addImage(img1, 'JPEG', 10, 20, 180, 100);

    doc.text("10 Categorías más vendidas", 10, 140,);
    let canvas2 = document.querySelector('#best_categories');
    let img2 = canvas2.toDataURL("image/jpeg", 1.0);
    doc.addImage(img2, 'JPEG', 10, 150, 180, 100);

    doc.addPage();

    doc.text("10 Productos más deseados", 10, 10,);
    let canvas3 = document.querySelector('#desired_products');
    let img3 = canvas3.toDataURL("image/jpeg", 1.0);
    doc.addImage(img3, 'JPEG', 10, 20, 180, 100);

    doc.text("10 mejores clientes", 10, 140,);
    let canvas4 = document.querySelector('#best_customers');
    let img4 = canvas4.toDataURL("image/jpeg", 1.0);
    doc.addImage(img4, 'JPEG', 10, 150, 180, 100);

    doc.addPage();

    doc.text("Pedidos por estado", 10, 10,);
    let canvas5 = document.querySelector('#orders_status');
    let img5 = canvas5.toDataURL("image/jpeg", 1.0);
    doc.addImage(img5, 'JPEG', 10, 20, 100, 100);

    doc.text("Pagos por estado", 10, 140,);
    let canvas6 = document.querySelector('#payments_status');
    let img6 = canvas6.toDataURL("image/jpeg", 1.0);
    doc.addImage(img6, 'JPEG', 10, 150, 100, 100);

    doc.save(`reporte ${startDate.value} a ${endDate.value}.pdf`);
}

</script>
<style>
#reportsContainers {
    display: grid;
    column-gap: 1em;
    row-gap: 1em;
    grid-template-columns: auto auto;
    margin-top: 2em;
}

.reportItem {
    max-width: 90%;
    margin: auto
}
</style>
<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getDataReports" class="flex">
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Fecha inicial </span></label>
                                <input
                                    type="date"
                                    id="startDate"
                                    v-model="startDate"
                                    class="input input-bordered input-primary"
                                    placeholder="ingresa una fecha inicial"
                                />
                            </div>
                            <div class="form-control w-full max-w-xs ml-2">
                                <label class="label">
                                    <span class="label-text">Fecha final</span>
                                </label>
                                <input
                                    type="date"
                                    id="endDate"
                                    v-model="endDate"
                                    class="input input-bordered input-primary"
                                    placeholder="ingresa una fecha final"
                                />
                            </div>

                            <button type="submit" class="btn btn-primary self-end ml-2">
                                Buscar
                            </button>
                            <button class="btn  self-end ml-2" @click="pdf" type="button">
                                <i class="fa fa-download"></i>
                            </button>
                        </form>
                    </div>
                    <div id="reportsContainers">
                        <BarChart id_name="best_products"  :data="bestProductsChart" name="10 Productos más vendidos" label="Unidades vendida"/>
                        <BarChart id_name="best_categories" :data="bestCategoriesChart" name="10 Categorías más vendidas" label="Unidades vendidas"/>
                        <BarChart id_name="desired_products" :data="desiredProductsChart" name="10 Productos más deseados" label="Unidades pedidas"/>
                        <BarChart id_name="best_customers" :data="bestCustomersChart" name="10 mejores clientes" label="Mejores clientes"/>
                        <PieChart id_name="orders_status" :data="ordersStatusChart" name="Pedidos por estado" label="Pedidos"/>
                        <PieChart id_name="payments_status" :data="paymentsStatusChart" name="Pagos por estado" label="Pagos"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
