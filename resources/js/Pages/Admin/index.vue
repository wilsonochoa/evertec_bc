<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Pagination from '@/Components/Pagination.vue'


defineProps({
    users: Object,
});
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Listar Usuarios
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
                    <th>name</th>
                    <th>email</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users.data">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                  </tr>
                </tbody>
              </table>
              <Pagination class="mt-6" :links="users.links" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>