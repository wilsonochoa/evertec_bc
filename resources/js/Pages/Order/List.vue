<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    title: String
})

const orders = ref([]);
const loadOrders = (url = null) => {
    axios.get(url || route('api.orders.getOrders')).then((response) => {
        orders.value = response.data.data;
    }).catch((error) => {
        console.log(error);
    });
}
loadOrders();
</script>

<template>
    <Head title="Listar Pedidos"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $page.props.$t.orders.plural_title }}
            </h2>
        </template>
        <div class="py-12">
            <div v-if="orders && orders.data?.length > 0" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="table w-full">
                                <thead>
                                <tr>
                                    <th>C&oacute;digo</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="order in orders.data">
                                    <td>{{ order.code }}</td>
                                    <td>$ {{ order.total_price.toLocaleString('es-CO') }}</td>
                                    <td>{{ new Date(order.created_at).toLocaleString('es-CO') }}</td>
                                    <td>
                                        {{ $page.props.$t.orders.status[order.status] }}
                                    </td>
                                    <td>
                                        <a :href="route('orders.show', order.id)" class="btn btn-active btn-primary"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <Pagination
                                class="mt-6"
                                :links="orders.links"
                                :click="loadOrders"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center">
                {{ $page.props.$t.orders.no_records }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>
