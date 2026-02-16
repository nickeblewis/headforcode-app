<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const navItems = page.props.navigation;
</script>

<template>
    <header
        class="sticky top-0 z-50 border-b border-border/50 bg-background/80 backdrop-blur-md"
    >
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <Link
                href="/"
                class="text-xl font-bold tracking-tight text-foreground transition-colors duration-300 hover:text-[var(--brand)]"
            >
                Headforcode
            </Link>
            <nav class="flex items-center gap-6">
                <Link
                    v-for="item in navItems"
                    :key="item.id"
                    :href="item.url"
                    class="relative text-sm font-medium text-muted-foreground transition-colors duration-300 hover:text-foreground"
                    :class="{
                        'text-foreground after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-[var(--brand)]':
                            $page.url === item.url,
                    }"
                >
                    {{ item.label }}
                </Link>
                <Link
                    href="/blog"
                    class="relative text-sm font-medium text-muted-foreground transition-colors duration-300 hover:text-foreground"
                    :class="{
                        'text-foreground after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-[var(--brand)]':
                            $page.url.startsWith('/blog'),
                    }"
                >
                    Blog
                </Link>
                <Link
                    href="/contact"
                    class="relative text-sm font-medium text-muted-foreground transition-colors duration-300 hover:text-foreground"
                    :class="{
                        'text-foreground after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-[var(--brand)]':
                            $page.url === '/contact',
                    }"
                >
                    Contact
                </Link>
            </nav>
        </div>
    </header>
</template>
