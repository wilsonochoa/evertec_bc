<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

const user = usePage().props.user;

const form = useForm({
  name: user.name,
  id: user.id,
});

const submit = () => {
  form.put(route("admin.updateProcess", user.id));
};

defineProps({
  user: Object,
});
</script>

<template>
  <Head title="Modificar Cliente" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Modificar Cliente
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submit">
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
              <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                  id="email"
                  type="email"
                  class="mt-1 block w-full"
                  v-model="user.email"
                  readonly
                />

                <InputError class="mt-2" :message="form.errors.email" />
              </div>
              <div class="flex items-center justify-end mt-4">
                <input type="hidden" name="id" :value="form.id" />
                <Link
                    :href="route('admin.home')"
                    class="ml-4"
                >Regresar
                </Link>
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Enviar
                </PrimaryButton>
                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>