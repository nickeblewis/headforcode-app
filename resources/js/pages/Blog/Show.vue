<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import type { Post } from '@/types/hygraph';

const props = defineProps<{
    post: Post;
}>();
</script>

<template>
    <Head :title="post.title">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden">
            <div
                class="bg-gradient-to-br from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] px-6 py-16 lg:py-20"
            >
                <div class="relative mx-auto max-w-4xl">
                    <Link
                        href="/blog"
                        class="group mb-6 inline-flex items-center gap-1 text-sm text-white/70 transition-colors duration-300 hover:text-white"
                    >
                        <span class="transition-transform duration-300 group-hover:-translate-x-1">&larr;</span>
                        Back to Blog
                    </Link>
                    <h1
                        class="animate-fade-in text-4xl font-bold tracking-tight text-white lg:text-5xl"
                    >
                        {{ post.title }}
                    </h1>
                    <div class="mt-6 flex items-center gap-4">
                        <div v-if="post.author" class="flex items-center gap-3">
                            <img
                                v-if="post.author.picture?.url"
                                :src="post.author.picture.url"
                                :alt="post.author.name"
                                class="h-10 w-10 rounded-full border-2 border-white/30 object-cover"
                            />
                            <div>
                                <p class="text-sm font-medium text-white">
                                    {{ post.author.name }}
                                </p>
                                <p v-if="post.author.bio" class="text-xs text-white/70">
                                    {{ post.author.bio }}
                                </p>
                            </div>
                        </div>
                        <time class="text-sm text-white/70">
                            {{ new Date(post.createdAt).toLocaleDateString() }}
                        </time>
                    </div>
                </div>
            </div>
        </section>

        <article class="mx-auto max-w-3xl px-6 py-12 lg:py-16">
            <div
                v-if="post.content?.html"
                class="prose prose-lg mx-auto dark:prose-invert"
                v-html="post.content.html"
            />
        </article>
    </PublicLayout>
</template>
