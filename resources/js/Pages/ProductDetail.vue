<script setup>
import {Head, usePage} from "@inertiajs/vue3";
import PageLogo from "@/Components/PageLogo.vue";
import UserMenu from "@/Components/UserMenu.vue";
import {ref} from "vue";
import {useCartStore} from "@/Stores/CartStore";
import CartIcon from "@/Components/CartIcon.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    product: Object,
    category: Object
});
const showStockError = ref(false);
const product = usePage().props.product;

const amount = ref(1);
const showAlert = ref(false);

const store = useCartStore();

const addToCart = async () => {
    if (amount.value < 1) {
        return;
    }

    if(amount.value > product.quantity){
        showStockError.value = true;
        setTimeout(() => showStockError.value = false, 5000);
        return;
    }

    let result = await store.add(product.id, amount.value);
    if(result){
        showAlert.value = true;
        setTimeout(() => showAlert.value = false, 2000);
    }else{
        showStockError.value = true;
        setTimeout(() => showStockError.value = false, 5000);
    }

}
</script>

<template>
    <Head title="Detalle producto"/>

    <div>
        <div class="flex p-4 border-b-2 justify-between items-center">
            <PageLogo/>
            <div class="flex justify-between items-center">
                <CartIcon/>
                <UserMenu/>
            </div>
        </div>
    </div>

    <div class="prose w-full mx-auto mb-6">
        <h2 class="w-full text-center p-5">{{ product.name }}</h2>
    </div>

    <div class="px-4 sm:columns-1 md:columns-2 ">
        <div class="mb-3">
            <figure v-if="product.image !== '' "  style="object-fit: contain;">
                <img :src="`/storage/${product.image}`" class="max-w-full mx-auto" :alt="product.name"
                     style="max-height: 720px;"/>
            </figure>
            <figure v-else   style="object-fit: contain;">
                <img :src="`/images/default.jpg`" class="max-w-full mx-auto" :alt="product.name"
                     style="max-height: 720px;"/>
            </figure>
        </div>

        <div class="prose">
            <span class="badge badge-outline block h-fit">{{ category.name }}</span>
            <p>{{ product.description }}</p>
            <h3>${{ product.price.toLocaleString('es-CO') }}</h3>
        </div>

        <div class="pt-8">
            <span>{{ $page.props.$t.labels.add_cart }}</span>
            <div class="flex">

                <input type="number" class="input input-bordered w-20" min="1" v-model="amount">
                <button class="btn btn-outline ml-1" @click="addToCart">
                    <i class="fa fa-cart-plus"></i>&nbsp;
                </button>
            </div>
            <p>Disponibles: {{ product.quantity }}</p>
            <div v-if="showStockError" class="alert alert-warning w-2/4 mt-2">
                {{ $page.props.$t.labels.stock_error }}
            </div>
        </div>
    </div>

    <div class="toast toast-middle toast-end " v-if="showAlert">
        <div class="alert alert-success">
            <span class="badge" id="amount">{{ amount }}</span><span>{{ $page.props.$t.labels.added_cart }}</span>
        </div>
    </div>

</template>
