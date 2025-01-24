<script setup>
defineProps({
    links: Object
});

const classes = (link) => {
    const baseClasses =
        "flex items-center justify-center px-3 h-8 p-5 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white";

    if (link.active != false) {
        return `${baseClasses} text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700`;
    }

    if (link.label === "Next &raquo;") {
        return `${baseClasses} rounded-e-lg`;
    }

    if (link.label === "&laquo; Previous") {
        return `${baseClasses} rounded-s-lg border-e-0`;
    }

    return baseClasses;
};
</script>

<template>
    <nav
        v-if="links && links.length > 0"
        class="inline-flex justify-center items-center py-4 -space-x-px text-sm text-center"
    >
        <a
            v-for="(link, index) in links"
            :key="index"
            :href="link.url"
            :class="classes(link)"
            v-html="link.label"
        >
        </a>
    </nav>
</template>
