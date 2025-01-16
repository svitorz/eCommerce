<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ToastManager from "@/Components/ToastManager.vue";
import ProductCard from "../Products/Components/ProductCard.vue";
import OrderSummary from "@/Pages/Orders/Components/OrderSummary.vue";
import OrderProductCard from "../Orders/Components/OrderProductCard.vue";
const props = defineProps({
    products: Array,
    subtotal: Number,
    recommended_products: { type: Array },
    is_admin: Boolean,
});

</script>

<template>
    <AppLayout>
        <template #header>
            <h2 class="text-white">Shopping Cart</h2>
        </template>

        <div v-if="products.length > 0">
            <section
                class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16"
            >
                <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                    <h2
                        class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl"
                    >
                        Shopping Cart
                    </h2>

                    <div
                        class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8"
                    >
                        <div
                            class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl"
                        >
                            <div class="space-y-6">
                                <div
                                    v-for="product in products"
                                    :key="product.id"
                                    class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6"
                                >
                                <OrderProductCard :product="product"/>
                            </div>
                            </div>
                            <div
                                class="hidden xl:mt-8 xl:block"
                                v-if="recommended_products.length > 0"
                            >
                                <h3
                                    class="text-2xl font-semibold text-gray-900 dark:text-white"
                                >
                                    People also bought
                                </h3>
                                <div
                                    class="mt-6 grid grid-cols-3 gap-4 sm:mt-8"
                                >
                                    <div
                                        v-for="recommended in recommended_products"
                                        class="space-y-6 overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800"
                                    >
                                        <ProductCard :product="recommended" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <OrderSummary :subtotal="subtotal" />
                    </div>
                </div>
            </section>
        </div>
        <div v-else>
            <h1 class="text-center text-white">No product found.</h1>
        </div>
    </AppLayout>
</template>
