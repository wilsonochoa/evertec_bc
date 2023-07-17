<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    title: String,
    categories: Array,
});

const searchTerm = ref("");
const category = ref("");
const products = ref([]);

const toggleStatus = (e) => {
    axios
        .patch(route("api.product.toggleStatus"), {id: e.target.dataset.product})
        .catch((err) => {
            console.error(err);
        });
};

const loadProducts = (url = null) => {
    axios
        .get(url || route("api.product.index"))
        .then((response) => {
            products.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

const searchProducts = () => {
    axios
        .get(
            `${route("api.product.index")}/?filter=${searchTerm.value}&category=${
                category.value
            }`
        )
        .then((response) => {
            products.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
};
loadProducts();
</script>

<template>
    <Head :title="title"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listar Productos
            </h2>
        </template>
        <div class="py-12">
            <div class="flex">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-2">
                    <form @submit.prevent="searchProducts" class="flex">
                        <input
                            type="text"
                            id="searchTerm"
                            v-model="searchTerm"
                            class="input input-bordered input-primary"
                            placeholder="ingresa un nombre"
                        />

                        <Select
                            class="input ml-2 block w-2/4 select"
                            v-model="category"
                            :options="categories"
                            :text="'categoría'"
                        />

                        <button type="submit" class="btn btn-primary ml-3 my-0">
                            Buscar
                        </button>
                    </form>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-2">
                    <a class="btn btn-active btn-primary" :href="route('products.create')">Crear producto</a>
                    <a
                        :href="route('products.import')"
                        class="btn btn-primary ml-1"
                    >
                        {{ $page.props.$t.labels.import }}
                    </a>
                    <a
                        :href="route('products.export')"
                        class="btn btn-primary ml-1"
                    >
                        {{ $page.props.$t.labels.export }}
                    </a>
                </div>
            </div>
            <div
                v-if="products && products.data?.length > 0"
                class="max-w-7xl mx-auto sm:px-6 lg:px-8"
            >
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="table w-full">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripci&oacute;n</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Estado</th>
                                    <th>Actualizar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product in products.data">
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.description.slice(0, 10) }} ...</td>
                                    <td>{{ product.category }}</td>
                                    <td>{{ product.price }}</td>
                                    <td>{{ product.quantity }}</td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            class="toggle toggle-success"
                                            :data-product="product.id"
                                            :checked="product.status === 1"
                                            @change="toggleStatus($event)"
                                        />
                                    </td>
                                    <td>
                                        <a
                                            class="btn btn-active btn-primary"
                                            :href="route('products.show', product.id)"
                                        >Actualizar</a
                                        >
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <Pagination
                                class="mt-6"
                                :links="products.links"
                                :filter="`&filter=${searchTerm}&category=${category}`"
                                :click="loadProducts"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
