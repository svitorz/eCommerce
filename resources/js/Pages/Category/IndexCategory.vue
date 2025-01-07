<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
defineProps({ categories: Object, isAdmin: Boolean })
</script>
<template>
    <AppLayout title="Category">
        <template #header>
            <div v-if="isAdmin">
                <PrimaryButton :type="button" class="float-end">
                    <a href="/categories/create">
                        Adicionar categoria
                    </a>
                </PrimaryButton>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                All Categories
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="d-flex justify-content-center align-items-center m-5">
                        <div v-for="category in categories">
                            <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">                       
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{category.name}}
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 pb-3">
                                {{category.description}}
                            </p>
                            <PrimaryButton :type="button">
                                <!-- TODO: implementar a busca dos produtos através da categoria. -->
                                    Ver produtos
                            </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>