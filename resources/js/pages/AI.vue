<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>

<template>
    <Head title="AI">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <section class="mx-auto max-w-6xl px-6 py-16 lg:py-24">
            <div class="text-center">
                <h1
                    class="mb-4 text-4xl font-bold tracking-tight text-[#1b1b18] lg:text-5xl dark:text-[#EDEDEC]"
                >
                    AI
                </h1>
                <p class="mx-auto max-w-2xl text-lg text-[#706f6c] dark:text-[#A1A09A]">
                    Artificial intelligence solutions and machine learning applications. Content
                    coming soon.
                </p>
            </div>
        </section>
    </PublicLayout>
</template>
