<script setup>
import { router, usePage } from "@inertiajs/vue3";
import ToastManager from "@/Components/ToastManager.vue";
import { ref } from "vue";
const toastRef = ref(null);
const { props: page } = usePage();
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});
console.log(props.product.isFavorite);
const addToFavorites = async () => {
    try {
        await router.post(
            route("favorite.store", {
                user: page.auth.user,
                product: props.product,
            }),
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    toastRef.value.showToast(
                        "Product added to favorites!",
                        "success",
                    );
                },
                onError: () => {
                    toastRef.value.showToast(
                        "Error removing localProduct from cart.",
                        "error",
                    );
                },
            },
        );
    } catch (error) {
        toastRef.value.showToast("Unexpected error", "error");
        console.log(error);
    }
};

const removeFromFavorites = async () => {
    try {
        await router.post(
            route("favorite.destroy", {
                user: page.auth.user,
                product: props.product,
            }),
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    toastRef.value.showToast(
                        "Product removed from favorites!",
                        "danger",
                    );
                },
                onError: () => {
                    toastRef.value.showToast(
                        "Error removing product from favorites.",
                        "error",
                    );
                },
            },
        );
    } catch (error) {
        toastRef.value.showToast("Unexpected error", "error");
        console.log(error);
    }
};
</script>
<template>
    <div>
        <button
            v-if="!product.isFavorite"
            @click.prevent="addToFavorites()"
            type="button"
            data-tooltip-target="tooltip-add-to-favorites"
            class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
        >
            <span class="sr-only"> Add to Favorites </span>
            <svg
                class="h-5 w-5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z"
                />
            </svg>
            <div
                id="tooltip-add-to-favorites"
                role="tooltip"
                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                data-popper-placement="top"
            >
                Add to favorites
                <div class="tooltip-arrow"></div>
            </div>
        </button>
        <button
            v-else
            @click.prevent="removeFromFavorites()"
            type="button"
            data-tooltip-target="tooltip-add-to-favorites"
            class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
        >
            <span class="sr-only"> Remove from Favorites </span>

            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="gray"
                stroke="gray"
                aria-hidden="true"
                stroke-width="2"
            >
                <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                />
            </svg>
            <div
                id="tooltip-remove-from-favorites"
                role="tooltip"
                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                data-popper-placement="top"
            >
                Remove from favorites
                <div class="tooltip-arrow"></div>
            </div>
        </button>
    </div>
    <ToastManager ref="toastRef" />
</template>
