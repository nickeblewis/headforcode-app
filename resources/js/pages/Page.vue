<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { Page } from '@/types/hygraph';

const props = defineProps<{
    page: Page;
}>();
</script>

<template>
    <Head :title="page.title">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden">
            <div
                class="bg-gradient-to-br from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] px-6 py-16 lg:py-20"
            >
                <div class="relative mx-auto max-w-4xl text-center">
                    <h1
                        class="animate-fade-in text-4xl font-bold tracking-tight text-white lg:text-5xl"
                    >
                        {{ page.title }}
                    </h1>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-3xl px-6 py-12 lg:py-16">
            <div
                v-if="page.content?.html"
                class="prose prose-lg mx-auto dark:prose-invert"
                v-html="page.content.html"
            />
        </section>
    </PublicLayout>
</template>
