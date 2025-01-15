<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import ToastManager from "@/Components/ToastManager.vue";
const loading = ref(false);
const toastRef = ref(null);
const props = defineProps({
    product: Object,
    isAdmin: Boolean,
});

const localProduct = computed({
    get: () => ({
        ...props.product,
    }),
    set: (newVal) => Object.assign(props.product, newVal)
});

const addToCart = async (product) => {
    loading.value = true;
    try {
        // Verifica se já está no carrinho
        if (product.inCart) {
            toastRef.value.showToast(
                "Product is already in cart!",
                "info"
            );
            loading.value = false;
            return;
        }

        if(product.quantity > product.stock){
            toastRef.value.showToast(
                "The quantity cannot be higher than stock.",
                "error"
            );
            loading.value = false;
            return;
        }

        await router.visit(route("cart.store", {
            product: {
                id: product.id,
                quantity: product.quantity
            }
        }), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toastRef.value.showToast(
                    "Product successfully added to cart!",
                    "success"
                );
                localProduct.value.inCart = true;
            },
            onError: () => {
                toastRef.value.showToast(
                    "Error adding product to cart.",
                    "error"
                );
            },
            onFinish: () => {
                loading.value = false;
            },
        });
    } catch (error) {
        toastRef.value.showToast("Unexpected error", "error");
        console.log(error);
        loading.value = false;
    }
};

const removeFromCart = async (product) => {
    loading.value = true;
    try {
        await router.visit(route("cart.destroy", {
            product: {
                id: product.id
            }
        }), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toastRef.value.showToast(
                    "Product removed from cart!",
                    "info"
                );
                localProduct.value.inCart = false;
                localProduct.value.quantity = 1; // Reset quantidade ao remover
            },
            onError: () => {
                toastRef.value.showToast(
                    "Error removing product from cart.",
                    "error"
                );
            },
            onFinish: () => {
                loading.value = false;
            },
        });
    } catch (error) {
        toastRef.value.showToast("Unexpected error", "error");
        console.log(error);
        loading.value = false;
    }
};
const buttonText = computed(() => {
    if (loading.value) {
        return localProduct.value.inCart ? "Removing..." : "Adding...";
    }
    return localProduct.value.inCart ? "Added" : "Add to Cart";
});

const handleCartAction = async () => {
    if (loading.value) return; // Previne múltiplos cliques

    try {
        if (localProduct.value.inCart) {
            await removeFromCart(localProduct.value);
        } else {
            await addToCart(localProduct.value);
        }
    } catch (error) {
        toastRef.value.showToast("Unexpected error", "error");
        console.log(error);
    }
    // Removemos o finally pois o loading já está sendo tratado nas funções
    // addToCart e removeFromCart em seus respectivos onFinish
};
</script>
<template>
    <form @submit.prevent="handleCartAction">
        <button
            :disabled="loading"
            type="submit"
            class="inline-flex items-center rounded-lg bg-gray-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
        >
            <svg
                class="-ms-2 me-2 h-5 w-5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6"
                />
            </svg>
            {{ buttonText }}
        </button>
    </form>
    <ToastManager ref="toastRef" />
</template>
