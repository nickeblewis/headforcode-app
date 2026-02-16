<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import InputError from '@/components/InputError.vue';
import ContactController from '@/actions/App/Http/Controllers/ContactController';

const page = usePage();

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

function submit() {
    form.post(ContactController.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Contact">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <PublicLayout>
        <section class="relative overflow-hidden">
            <div
                class="bg-gradient-to-br from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] px-6 py-16 lg:py-20"
            >
                <div class="relative mx-auto max-w-2xl text-center">
                    <h1
                        class="animate-fade-in mb-4 text-4xl font-bold tracking-tight text-white lg:text-5xl"
                    >
                        Contact
                    </h1>
                    <p class="animate-fade-in-up text-lg text-white/80" style="animation-delay: 0.15s">
                        Have a question or want to work together? Send me a message.
                    </p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-2xl px-6 py-12 lg:py-16">
            <div
                v-if="page.props.flash?.success"
                class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400"
            >
                {{ page.props.flash.success }}
            </div>

            <form
                @submit.prevent="submit"
                class="animate-fade-in-up space-y-6 rounded-xl border border-border bg-card p-6 shadow-lg lg:p-8"
                style="animation-delay: 0.2s"
            >
                <div>
                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-card-foreground"
                    >
                        Name
                    </label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="w-full rounded-lg border border-border bg-background px-4 py-2.5 text-foreground placeholder-muted-foreground transition-all duration-200 focus:border-[var(--brand)] focus:outline-none focus:ring-2 focus:ring-[var(--brand)]/25"
                        placeholder="Your name"
                    />
                    <InputError :message="form.errors.name" class="mt-1" />
                </div>

                <div>
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-card-foreground"
                    >
                        Email
                    </label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="w-full rounded-lg border border-border bg-background px-4 py-2.5 text-foreground placeholder-muted-foreground transition-all duration-200 focus:border-[var(--brand)] focus:outline-none focus:ring-2 focus:ring-[var(--brand)]/25"
                        placeholder="you@example.com"
                    />
                    <InputError :message="form.errors.email" class="mt-1" />
                </div>

                <div>
                    <label
                        for="subject"
                        class="mb-2 block text-sm font-medium text-card-foreground"
                    >
                        Subject
                    </label>
                    <input
                        id="subject"
                        v-model="form.subject"
                        type="text"
                        class="w-full rounded-lg border border-border bg-background px-4 py-2.5 text-foreground placeholder-muted-foreground transition-all duration-200 focus:border-[var(--brand)] focus:outline-none focus:ring-2 focus:ring-[var(--brand)]/25"
                        placeholder="What's this about?"
                    />
                    <InputError :message="form.errors.subject" class="mt-1" />
                </div>

                <div>
                    <label
                        for="message"
                        class="mb-2 block text-sm font-medium text-card-foreground"
                    >
                        Message
                    </label>
                    <textarea
                        id="message"
                        v-model="form.message"
                        rows="5"
                        class="w-full rounded-lg border border-border bg-background px-4 py-2.5 text-foreground placeholder-muted-foreground transition-all duration-200 focus:border-[var(--brand)] focus:outline-none focus:ring-2 focus:ring-[var(--brand)]/25"
                        placeholder="Your message..."
                    />
                    <InputError :message="form.errors.message" class="mt-1" />
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-lg bg-gradient-to-r from-[var(--brand-gradient-from)] to-[var(--brand-gradient-to)] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[var(--brand)]/25 transition-all duration-300 hover:shadow-xl hover:shadow-[var(--brand)]/30 hover:brightness-110 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span v-if="form.processing">Sending...</span>
                    <span v-else>Send Message</span>
                </button>
            </form>
        </section>
    </PublicLayout>
</template>
