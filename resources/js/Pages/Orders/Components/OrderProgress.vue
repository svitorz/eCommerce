<script setup>
import { computed } from "vue";

const props = defineProps({
    currentStatus: {
        type: String,
        required: true,
    },
});

// Etapas e lógica para mapear o progresso
const steps = computed(() => {
    const statuses = [
        {
            key: "pending_payment",
            title: "Pending Payment",
            description: "Awaiting payment confirmation.",
            iconPath:
                "M4 12l8-8 8 8M6 10.5V19a1 1 0 001 1h3v-3a1 1 0 011-1h2a1 1 0 011 1v3h3a1 1 0 001-1v-8.5",
        },
        {
            key: "transporting",
            title: "Transporting",
            description: "Your order is on the way.",
            iconPath:
                "M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 00-1-1H4a1 1 0 00-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5",
        },
        {
            key: "completed",
            title: "Order Completed",
            description: "The order has been successfully delivered.",
            iconPath: "M5 11.917L9.724 16.5 19 7.5",
        },
    ];

    // Determinar o status atual, completado e ativo
    let statusReached = true;
    return statuses.map((step) => {
        if (step.key === currentStatus) {
            statusReached = false;
            return { ...step, isActive: true, isCompleted: false };
        } else if (statusReached) {
            return { ...step, isActive: false, isCompleted: true };
        } else {
            return { ...step, isActive: false, isCompleted: false };
        }
    });
});
</script>
<template>
    <div class="mt-6 grow sm:mt-8 lg:mt-0">
        <div
            v-if="props.currentStatus === 'canceled'"
            class="rounded-lg border border-red-200 bg-red-50 p-6 shadow-sm dark:border-red-700 dark:bg-red-800"
        >
            <h3 class="text-xl font-semibold text-red-700 dark:text-red-400">
                Order Canceled
            </h3>
            <p class="mt-2 text-gray-700 dark:text-gray-300">
                The order has been canceled and will not be processed further.
            </p>
        </div>

        <div
            v-else
            class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800"
        >
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Order History
            </h3>

            <ol
                class="relative ms-3 border-s border-gray-200 dark:border-gray-700"
            >
                <li
                    v-for="(step, index) in steps"
                    :key="index"
                    :class="[
                        'mb-10 ms-6',
                        step.isCompleted
                            ? 'text-primary-700 dark:text-primary-500'
                            : step.isActive
                            ? 'text-gray-900 dark:text-white'
                            : 'text-gray-500 dark:text-gray-400',
                    ]"
                >
                    <span
                        class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full"
                        :class="[
                            step.isCompleted
                                ? 'bg-primary-100 ring-8 ring-white dark:bg-primary-900 dark:ring-gray-800'
                                : step.isActive
                                ? 'bg-primary-300 ring-8 ring-white dark:bg-primary-500 dark:ring-gray-800'
                                : 'bg-gray-100 ring-8 ring-white dark:bg-gray-700 dark:ring-gray-800',
                        ]"
                    >
                        <svg
                            class="h-4 w-4"
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
                                :d="step.iconPath"
                            />
                        </svg>
                    </span>

                    <h4 class="mb-0.5 text-base font-semibold">
                        {{ step.title }}
                    </h4>
                    <p
                        v-if="step.description"
                        class="text-sm font-normal text-gray-500 dark:text-gray-400"
                    >
                        {{ step.description }}
                    </p>
                </li>
            </ol>
        </div>
    </div>
</template>
