import {defineStore} from 'pinia';
import {computed, ref} from "vue";

export const useCartStore = defineStore('cart', () => {

    const products = ref({})
    const current = localStorage.getItem('cart');
    if (current) {
        products.value = JSON.parse(current).products;
    }

    const amount = computed(() => {
        let n = 0;
        for (const item of Object.values(products.value)) {
            n += item;
        }

        return n;
    });

    async function add(id, amount) {
        let response = true;
        if(amount > 0 && products.value.hasOwnProperty(id)) {
            await axios.post(route('api.valquantity'), {id: id, amount:products.value[id]})
                .then((e) => {
                    response = e.data.data.response;
                    if (products.value.hasOwnProperty(id) && e.data.data.response) {
                        products.value[id] += amount;
                    } else if(e.data.data.response){
                        products.value[id] = amount;
                    }
                })
                .catch((e) => console.log(e));
        }else{
            if (products.value.hasOwnProperty(id)) {
                products.value[id] += amount;
            } else {
                products.value[id] = amount;
            }
        }
        return response;
    }

    function deleteProduct(id) {
        Reflect.deleteProperty(products.value, id);
    }

    function clear() {
        products.value = {};
    }

    return {products, amount, add, deleteProduct, clear}
});
