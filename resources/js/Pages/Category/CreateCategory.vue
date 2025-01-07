<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const form = reactive({
    name: null,
    description: null,
});

function submit() {
    router.post('/categories/', form);
}
</script>
<template>
    <AppLayout title="Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Category
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="d-flex justify-content-center align-items-center m-5">
                        <form @submit.prevent="submit">
                            <!-- Category name -->
                            <InputLabel for="name" value="Category Name" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="name"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                             <!-- END CATEGORY NAME -->

                             <!-- Category Description -->
                            <InputLabel for="descrption" value="Category Description" />
                            
                            <TextInput
                                id="description"
                                v-model="form.description"
                                type="description"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <!-- <InputError class="mt-2" :message="form.errors.description" /> -->
                            <!-- End category description -->
                             <!-- Save button -->
                            <PrimaryButton class="my-3 float-end">
                                Create 
                            </PrimaryButton>
                            <!-- End save button -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>