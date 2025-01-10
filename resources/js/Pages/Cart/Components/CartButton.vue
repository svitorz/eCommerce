<script setup>
import { ref, computed, watch, onMounted } from "vue";
const emit = defineEmits(["toastedRef"]);
// Props recebidas
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const loading = ref(false);

const toastRef = ref(null);

watch(toastRef, () => {
    emit('toast', toastRef)
})
const addToCart = async (product) => {
    loading.value = true;
    try {
        await router.visit(route("cart.store", { product: product }), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toastRef.value.showToast(
                    "Product succsessfully added to card!",
                    "success"
                );
                props.product.inCart = true;
            },
            onError: () => {
                toastRef.value.showToast(
                    "Error aditioning product on card.",
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
        await router.visit(route("cart.destroy", { product }), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toastRef.value.showToast(
                    "Product removed from cart!",
                    "success"
                );
                props.product.inCart = false;
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

// Texto dinâmico do botão
const buttonText = computed(() => {
    if (loading.value) {
        return props.product.inCart ? "Removing..." : "Adding...";
    }
    return props.product.inCart ? "Added" : "Add to Cart";
});

// Função para tratar a ação do carrinho
const handleCartAction = async () => {
    loading.value = true;

    try {
        if (props.product.inCart) {
            // Remove do carrinho
            await removeFromCart(props.product);
        } else {
            // Adiciona ao carrinho
            await addToCart(props.product);
        }
    } finally {
        loading.value = false;
    }
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
</template>
