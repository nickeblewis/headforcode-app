<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>

<template>
    <Head title="Code">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <section class="mx-auto max-w-6xl px-6 py-16 lg:py-24">
            <div class="text-center">
                <h1
                    class="mb-4 text-4xl font-bold tracking-tight text-[#1b1b18] lg:text-5xl dark:text-[#EDEDEC]"
                >
                    Code
                </h1>
                <p class="mx-auto max-w-2xl text-lg text-[#706f6c] dark:text-[#A1A09A]">
                    Robust backend solutions with Laravel, PHP, and modern development practices.
                    Content coming soon.
                </p>
            </div>
        </section>
    </PublicLayout>
</template>
