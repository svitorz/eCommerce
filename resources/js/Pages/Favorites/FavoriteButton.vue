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

const localProduct = ref(props.product);

const addToFavorites = async () => {
    try {
        await router.visit(
            route("favorite.store", {
                user: page.auth.user,
                product: localProduct.value.id,
            }),
            {
                method: "POST",
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    toastRef.value.showToast(
                        "Product added to favorites!",
                        "success",
                    );
                    localProduct.value.isFavorite = true;
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
        await router.visit(
            route("favorite.destroy", {
                user: page.auth.user,
                product: localProduct.value.id,
            }),
            {
                method: "POST",
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    toastRef.value.showToast(
                        "Product removed from favorites!",
                        "warning",
                    );
                    localProduct.value.isFavorite = false;
                    console.log("Success");
                },
                onError: () => {
                    toastRef.value.showToast(
                        "Error removing product from favorites.",
                        "error",
                    );
                    console.log("Error");
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
    <div v-if="localProduct">
        <div v-if="!localProduct.isFavorite">
            <button
                @click="addToFavorites()"
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
            </button>
            <div
                id="tooltip-add-to-favorites"
                role="tooltip"
                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                data-popper-placement="top"
            >
                Add to favorites
                <div class="tooltip-arrow"></div>
            </div>
        </div>
        <div v-else>
            <button
                @click="removeFromFavorites()"
                type="button"
                data-tooltip-target="tooltip-add-to-favorites"
                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >
                <span class="sr-only"> Remove from Favorites </span>

                <svg
                    class="h-5 w-5"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z"
                    />
                </svg>
            </button>
            <div
                id="tooltip-remove-from-favorites"
                role="tooltip"
                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700"
                data-popper-placement="top"
            >
                Remove from favorites
                <div class="tooltip-arrow"></div>
            </div>
        </div>
    </div>
    <ToastManager ref="toastRef" />
</template>
