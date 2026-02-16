<script setup lang="ts">
import PublicNavigation from '@/components/PublicNavigation.vue';
import PublicFooter from '@/components/PublicFooter.vue';
</script>

<template>
    <div class="relative flex min-h-screen flex-col bg-background text-foreground">
        <div
            class="pointer-events-none fixed inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--brand-gradient-from)_0%,_transparent_50%)] opacity-[0.03] dark:opacity-[0.07]"
        />
        <PublicNavigation />
        <main class="relative flex-1">
            <slot />
        </main>
        <PublicFooter />
    </div>
</template>
