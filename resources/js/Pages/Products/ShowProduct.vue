<script setup>
import { defineProps,ref, reactive,watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Dropdown from "@/Components/Dropdown.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DialogModal from "@/Components/DialogModal.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import CartButton from "../Cart/Components/CartButton.vue";
import ToastManager from "@/Components/ToastManager.vue";

const props = defineProps({
    product: Array,
    isAdmin: Boolean,
});

const localProduct = reactive({ ...props.product });

// Sincronize mudanças de `props.product` com `localProduct`
watch(
    () => props.product,
    (newVal) => {
        Object.assign(localProduct, newVal);
    },
    { deep: true, immediate: true }
);
// Atualize o valor local
function updateProductQuantity(quantity) {
    localProduct.value.quantity = quantity;
}
const toastRef = ref(null);

function verifyQuantity(){
    if(localProduct.value.quantity > localProduct.value.stock){
        localProduct.value.quantity = localProduct.value.stock;
        toastRef.value.showToast(
            "The quantity cannot be higher than stock.",
            "error"
        );
    }else if(localProduct.value.quantity < 1) {
        localProduct.value.quantity = 1;
        toastRef.value.showToast(
            "The quantity cannot be lower than 1.",
            "error"
        );
    }
}
// functions
const form = useForm({
    deleteProductId: 0,
});

const confirmingDelete = ref(false);
const confirmDelete = () => {
    confirmingDelete.value = true;
};

const closeModal = () => {
    confirmingDelete.value = false;
};

const deleteProduct = (deleteProductId) => {
    form.delete(route("products.destroy", deleteProductId), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};
</script>

<template>
    <AppLayout :title="localProduct?.name">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ localProduct.category.name }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-center mb-4 md:mb-8">
                    <div
                        class="m-2 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800"
                    >
                    <!-- delete and edit dropdown -->
                    <!-- dropdown to edit and exclude the category buttons-->
                    <Dropdown align="right" width="48" v-if="isAdmin">
                        <template #trigger>
                            <span
                                class="inline-flex rounded-md float-end"
                            >
                                <button
                                    type="button"
                                    class="m-5 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                >
                                    <svg
                                        class="ms-2 -me-0.5 size-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <!-- content -->
                            <DropdownLink
                                :href="
                                    route(
                                        'products.edit',
                                        localProduct.id
                                    )
                                "
                            >
                                Edit Product
                            </DropdownLink>
                            <div
                                class="border-t border-gray-200 dark:border-gray-600"
                            />
                            <DropdownLink
                                as="button"
                                @click="confirmDelete"
                            >
                                Delete Product
                            </DropdownLink>
                        </template>
                    </Dropdown>
                    <!-- end dropdown -->
                    <!-- Confirmation Dialog -->
                    <DialogModal
                        :show="confirmingDelete"
                        @close="closeModal"
                    >
                        <template #title>
                            Delete this Product?
                        </template>

                        <template #content>
                            This action is irreversible!
                        </template>

                        <template #footer>
                            <SecondaryButton
                                :type="button"
                                @click="closeModal"
                            >
                                Cancel
                            </SecondaryButton>

                            <DangerButton
                                :type="button"
                                class="ms-3"
                                :class="{
                                    'opacity-25': form.processing,
                                }"
                                :disabled="form.processing"
                                @click="deleteProduct(localProduct.id)"
                            >
                                Delete
                            </DangerButton>
                        </template>
                    </DialogModal>
                    <!--  Confirmation Dialog -->
                    <section
                            class="p-8 bg-white dark:text-white md:py-16 dark:bg-gray-900 antialiased"
                        >

                            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                                <div
                                    class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16"
                                >
                                    <div
                                        class="shrink-0 max-w-md lg:max-w-lg mx-auto"
                                    >
                                        <img
                                            class="w-full dark:hidden ms-1"
                                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front.svg"
                                            alt=""
                                        />
                                        <img
                                            class="w-full hidden dark:block ms-1"
                                            src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg"
                                            alt=""
                                        />
                                    </div>

                                    <div class="mt-6 sm:mt-8 lg:mt-0">
                                        <h1
                                            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
                                        >
                                            <!-- product name -->
                                            {{ localProduct.name }}
                                        </h1>
                                        <div
                                            class="mt-4 sm:items-center sm:gap-4 sm:flex"
                                        >
                                            <p
                                                class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white"
                                            >
                                                ${{ localProduct.price }}
                                            </p>

                                            <div
                                                class="flex items-center gap-2 mt-2 sm:mt-0"
                                            >
                                                <div
                                                    class="flex items-center gap-1"
                                                >
                                                    <svg
                                                        class="w-4 h-4 text-yellow-300"
                                                        aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                                                        />
                                                    </svg>
                                                    <svg
                                                        class="w-4 h-4 text-yellow-300"
                                                        aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                                                        />
                                                    </svg>
                                                    <svg
                                                        class="w-4 h-4 text-yellow-300"
                                                        aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                                                        />
                                                    </svg>
                                                    <svg
                                                        class="w-4 h-4 text-yellow-300"
                                                        aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                                                        />
                                                    </svg>
                                                    <svg
                                                        class="w-4 h-4 text-yellow-300"
                                                        aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                                                        />
                                                    </svg>
                                                </div>
                                                <p
                                                    class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400"
                                                >
                                                    <!-- rating -->
                                                    (5.0)
                                                </p>
                                                <a
                                                    href="#"
                                                    class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline dark:text-white"
                                                >
                                                    345 Reviews
                                                </a>
                                            </div>
                                        </div>
                                        <div
                                            class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8"
                                        >
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                {{localProduct.stock}} avaliable.
                                            </p>
                                            <div>
                                                <InputLabel for="quantity" value="Quantity" />
                                                <TextInput
                                                     @input="verifyQuantity"
                                                    id="quantity"
                                                    v-model="localProduct.quantity"
                                                    type="number"
                                                    class="mt-1 w-full h-12"
                                                    :max="localProduct.stock"
                                                    required
                                                    autofocus
                                                />
                                            </div>
                                        </div>
                                        <div
                                            class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8"
                                        >
                                            <a
                                                href="#"
                                                title=""
                                                class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                                role="button"
                                            >
                                                <svg
                                                    class="w-5 h-5 -ms-2 me-2"
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
                                                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"
                                                    />
                                                </svg>
                                                Add to favorites
                                            </a>
                                            <CartButton @click="updateProductQuantity":product="localProduct"/>
                                        </div>

                                        <hr
                                            class="my-6 md:my-8 border-gray-200 dark:border-gray-800"
                                        />

                                        <p
                                            class="mb-6 text-gray-500 dark:text-gray-400"
                                        >
                                            {{ localProduct.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <ToastManager ref="toastRef" />
    </AppLayout>
</template>
