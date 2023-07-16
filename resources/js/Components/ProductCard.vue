<script setup>
defineProps({
    product: Object
})
</script>

<template>
    <a :href="route('product-detail', product.slug)">
        <div class="card card-compact bg-base-100 shadow-lg ">
            <figure v-if="product.image !== '' " style="object-fit: contain; height: 200px">
                <img  :src="`/storage/${product.image}`" :alt="product.name"/>
            </figure>
            <figure v-else style="object-fit: contain; height: 200px">
                <img  :src="`/images/default.jpg`" :alt="product.name"/>
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ product.name }}</h2>
                <p>{{product.description.slice(0, 150)}}...</p>
                <p>${{ product.price.toLocaleString('es-CO') }}</p>
                <div class="badge badge-outline">{{ product.category }}</div>
            </div>
        </div>
    </a>
</template>
