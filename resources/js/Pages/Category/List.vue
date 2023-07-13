<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    title: String
})

const categories = ref([]);
const toggleStatus = (e) => {
  axios.patch(route('api.categories.toggleStatus'), {id: e.target.dataset.category}).catch((err) => {
        console.error(err);
    });
}
const loadCategories = (url = null) => {
    axios.get(url || route('api.categories')).then((response) => {
        categories.value = response.data.data;
    }).catch((error) => {
        console.log(error);
    });
}
loadCategories();
</script>

<template>
  <Head title="Listar Categorias" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Listar Clientes
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-2">
        <a class="btn btn-active btn-primary" :href="route('categories.create')"
          >Crear categoria</a>
      </div>

      <div v-if="categories && categories.data?.length > 0" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
              <table class="table w-full">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Actualizar</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="category in categories.data">
                    <td>{{ category.name }}</td>
                    <td>
                      <a
                        class="btn btn-active btn-primary"
                        :href="route('categories.show', category.id)"
                        >Actualizar</a
                      >
                    </td>
                    <td>
                      <input
                        type="checkbox"
                        class="toggle toggle-success"
                        :data-category="category.id"
                        :checked="category.status === 1"
                        @change="toggleStatus($event)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
              <Pagination
                class="mt-6"
                :links="categories.links"
                :click="loadCategories"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
