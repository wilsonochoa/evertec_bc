<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";


const users = ref([]);

const toggleStatus = (e) => {
    axios.patch(route('api.customers.toggleStatus'), {id: e.target.dataset.user}).catch((err) => {
        console.error(err);
    });
}


const loadCustomers = (url = null) => {
    axios.get(url || route('api.customers')).then((response) => {
        users.value = response.data.data;
    }).catch((error) => {
        console.log(error);
    });
}

loadCustomers();
</script>

<template>
  <Head title="Listar Clientes" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Listar Clientes
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
              <table class="table w-full">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Actualizar</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users.data">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                      <a
                        class="btn btn-active btn-primary"
                        :href="route('admin.update', user.id)"
                        >Actualizar</a
                      >
                    </td>
                    <td><input type="checkbox" class="toggle toggle-success"
                      :data-user="user.id"
                      :checked="user.status === 1"
                      @change="toggleStatus($event)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
              <Pagination
                  class="mt-6"
                  :links="users.links"
                  :click="loadCustomers" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
