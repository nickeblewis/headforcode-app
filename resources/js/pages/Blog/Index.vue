<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { Post } from '@/types/hygraph';

const props = defineProps<{
    posts: Post[];
}>();
</script>

<template>
    <Head title="Blog">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden">
            <div
                class="bg-gradient-to-br from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] px-6 py-16 lg:py-20"
            >
                <div class="relative mx-auto max-w-6xl text-center">
                    <h1
                        class="animate-fade-in text-4xl font-bold tracking-tight text-white lg:text-5xl"
                    >
                        Blog
                    </h1>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-6xl px-6 py-12 lg:py-16">
            <div v-if="posts.length" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <Link
                    v-for="(post, index) in posts"
                    :key="post.slug"
                    :href="`/blog/${post.slug}`"
                    class="animate-fade-in-up group overflow-hidden rounded-xl border border-border bg-card shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
                    :style="{ animationDelay: `${0.1 * index}s` }"
                >
                    <img
                        :src="`https://placehold.co/600x300/4338ca/ffffff?text=${encodeURIComponent(post.title)}`"
                        :alt="post.title"
                        class="h-44 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    />
                    <div class="relative p-6">
                        <div
                            class="absolute inset-x-0 top-0 h-0.5 bg-gradient-to-r from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        />
                        <h2
                            class="mb-2 text-lg font-semibold text-card-foreground transition-colors duration-300 group-hover:text-[var(--brand)]"
                        >
                            {{ post.title }}
                        </h2>
                        <p class="mb-4 text-sm text-muted-foreground">
                            {{ post.excerpt }}
                        </p>
                        <div class="flex items-center gap-2 text-xs text-muted-foreground">
                            <span v-if="post.author">{{ post.author.name }}</span>
                            <span v-if="post.author">&middot;</span>
                            <time>{{ new Date(post.createdAt).toLocaleDateString() }}</time>
                        </div>
                    </div>
                </Link>
            </div>

            <p v-else class="text-center text-lg text-muted-foreground">
                No posts yet. Check back soon.
            </p>
        </section>
    </PublicLayout>
</template>
