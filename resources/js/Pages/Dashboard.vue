<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SearchInput from "./Products/Components/SearchInput.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <div class="p-5">
                        <h1 class="pb-5 text-3xl text-center dark:text-white">
                            Search for products or categories:
                        </h1>
                        <SearchInput />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
