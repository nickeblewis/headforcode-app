<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { Page } from '@/types/hygraph';

const props = defineProps<{
    page: Page | null;
}>();

const navItems = usePage().props.navigation as {
    id: string;
    label: string;
    subtitle: string | null;
    url: string;
    image: string | null;
}[];

function cardImage(item: (typeof navItems)[number]): string {
    if (item.image) {
        return item.image;
    }

    const seed = item.id.slice(0, 8);

    return `https://source.unsplash.com/600x300/?technology,code&sig=${seed}`;
}
</script>

<template>
    <Head title="Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden px-6 py-20 lg:py-32">
            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[var(--brand-gradient-from)]/5 to-transparent dark:from-[var(--brand-gradient-from)]/10"
            />
            <div
                class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-[var(--brand-gradient-to)]/10 blur-3xl dark:bg-[var(--brand-gradient-to)]/20"
            />
            <div
                class="pointer-events-none absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-[var(--brand-accent)]/10 blur-3xl dark:bg-[var(--brand-accent)]/15"
            />

            <div class="relative mx-auto max-w-6xl text-center">
                <h1
                    class="animate-fade-in mb-6 text-5xl font-bold tracking-tight lg:text-7xl"
                >
                    <span class="gradient-text">{{ page?.title ?? 'Headforcode' }}</span>
                </h1>
                <p
                    class="animate-fade-in-up mx-auto max-w-2xl text-lg text-muted-foreground lg:text-xl"
                    style="animation-delay: 0.15s"
                >
                    Building modern software solutions with AI, frontend excellence, and robust
                    backend architectures.
                </p>
                <div class="animate-fade-in-up mt-10" style="animation-delay: 0.3s">
                    <Link
                        href="/contact"
                        class="inline-block rounded-lg bg-gradient-to-r from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[var(--brand)]/25 transition-all duration-300 hover:shadow-xl hover:shadow-[var(--brand)]/30 hover:brightness-110"
                    >
                        Get in Touch
                    </Link>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-6xl px-6 pb-20 lg:pb-28">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="(item, index) in navItems"
                    :key="item.id"
                    :href="item.url"
                    class="animate-fade-in-up group cursor-pointer overflow-hidden rounded-xl border border-border bg-card shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                    :style="{ animationDelay: `${0.1 * index + 0.3}s` }"
                >
                    <img
                        :src="cardImage(item)"
                        :alt="item.label"
                        class="h-40 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    />
                    <div class="relative p-6">
                        <div
                            class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        />
                        <h3
                            class="mb-2 text-lg font-semibold text-card-foreground transition-colors duration-300 group-hover:text-[var(--brand)]"
                        >
                            {{ item.label }}
                        </h3>
                        <p v-if="item.subtitle" class="text-sm text-muted-foreground">
                            {{ item.subtitle }}
                        </p>
                    </div>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
