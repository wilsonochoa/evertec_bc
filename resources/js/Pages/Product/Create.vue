<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Select from "@/Components/Select.vue";
import FileInput from "@/Components/FileInput.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
  title: String,
  categories: Array,
});

const categories = usePage().props.categories;

const form = useForm({
  name: "",
  description: "",
  price: 0,
  image: null,
  quantity: 0,
  category_id: "",
  status: false,
});

const submit = () => {
  form.post(route("product.store"), {
    forceFormData: true,
  });
};
</script>

<template>
  <Head :title="title" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear producto
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submit" enctype="multipart/form-data">
              <div>
                <InputLabel for="name" value="Nombre" />

                <TextInput
                  id="name"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.name"
                  required
                  autofocus
                  autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
              </div>
              <div>
                <InputLabel for="description" value="Descripción" />

                <TextInput
                  id="description"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.description"
                  required
                  autofocus
                  autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
              </div>
              <div>
                <InputLabel for="price" value="Precio" />

                <TextInput
                  id="price"
                  type="number"
                  class="mt-1 block w-full"
                  v-model="form.price"
                  required
                  autofocus
                  autocomplete="price"
                />

                <InputError class="mt-2" :message="form.errors.price" />
              </div>
              <div>
                <InputLabel for="quantity" value="Cantidad" />

                <TextInput
                  id="quantity"
                  type="number"
                  class="mt-1 block w-full"
                  v-model="form.quantity"
                  required
                  autofocus
                  autocomplete="quantity"
                />

                <InputError class="mt-2" :message="form.errors.quantity" />
              </div>
              <div class="mt-3">
                <InputLabel for="category_id" value="Categoría" />
                <Select
                  id="category_id"
                  class="input mt-1 block w-full select"
                  v-model="form.category_id"
                  :options="categories"
                  required
                  autofocus
                />
                <InputError class="mt-2" :message="form.errors.category_id" />
              </div>
              <div class="mt-3">
                <InputLabel for="status" value="Estado" />
                <input
                  type="checkbox"
                  name="status"
                  id="status"
                  v-model="form.status"
                  class="toggle toggle-success"
                />
              </div>
              <div class="mt-3">
                <InputLabel for="image" value="Imagen" />
                <FileInput
                  id="image"
                  class="input mt-1 block w-full"
                  v-model="form.image"
                  required
                  autofocus
                  autocomplete="image"
                />
                <InputError class="mt-2" :message="form.errors.image" />
              </div>

              <div class="flex items-center justify-end mt-4">
                <Link :href="route('admin.home')" class="ml-4">Regresar </Link>
                <PrimaryButton
                  class="ml-4"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Enviar
                </PrimaryButton>
                <Transition
                  enter-from-class="opacity-0"
                  leave-to-class="opacity-0"
                  class="transition ease-in-out"
                >
                  <p
                    v-if="form.recentlySuccessful"
                    class="text-sm text-gray-600"
                  >
                    Saved.
                  </p>
                </Transition>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>