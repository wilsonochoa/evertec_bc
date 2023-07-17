<script setup>
import {ref} from "vue";
import {Head, Link} from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
import Pagination from "@/Components/Pagination.vue";
import Select from "@/Components/Select.vue";
import CartIcon from "@/Components/CartIcon.vue";
import {useCartStore} from "@/Stores/CartStore";

const store = useCartStore();

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  products: Object,
  categories: Array,
});
const searchTerm = ref("");
const category = ref("");
const products = ref([]);

const searchProducts = () => {
  axios
    .get(`${route("api.product.home")}/?filter=${searchTerm.value}&category=${
        category.value
      }`)
    .then((response) => {
      products.value = response.data.data;
    })
    .catch((error) => {
      console.log(error);
    });
};
const loadProducts = (url = null) => {
  axios
    .get(url || route("api.product.home"))
    .then((response) => {
      products.value = response.data.data;
    })
    .catch((error) => {
      console.log(error);
    });
};
loadProducts();

const clearStorage = () => {
   store.clear();
};
</script>

<template>
  <Head title="Welcome" />

  <div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
  >
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
        <Link style="margin-right: 2em"
              v-if="$page.props.auth.user && $page.props.auth.rol.roles[0] === 'Admin'"
              :href="route('dashboard')"
              class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >Dashboard</Link
        >
      <Link style="margin-right: 2em"
        v-if="$page.props.auth.user"
        :href="route('order.index')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >Pedidos</Link
      >
      <Link
        v-if="$page.props.auth.user"
        :href="route('logout')"
        method="post"
        @click="clearStorage"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >Cerrar sesion
    </Link>
      <template v-else>
        <Link
          :href="route('login')"
          class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >Log in</Link
        >

        <Link
          v-if="canRegister"
          :href="route('register')"
          class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >Register</Link
        >
      </template>
    </div>

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
      <div class="flex justify-center">
          <div class="flex justify-between items-center">
              <CartIcon/>
          </div>
      </div>

      <div class="mt-16">
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
        </div>
        <div class="grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
          <div
            class="container mx-auto grid grid-cols-4 gap-6"
            v-if="products && products.data?.length > 0"
          >
            <div v-for="product in products.data">
              <ProductCard :product="product" />
            </div>
          </div>
          <div v-else class="mx-auto">
            <p class="mx-auto text-white alert alert-info w-1/4">
              No se encontraron productos
            </p>
          </div>
          <Pagination
            v-if="products && products.data?.length > 0"
            class="mt-6"
            :links="products.links"
            :filter="`&filter=${searchTerm}&category=${category}`"
            :click="loadProducts"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
