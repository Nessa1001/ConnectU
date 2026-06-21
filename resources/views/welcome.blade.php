<x-layouts::guest :title="__('Welcome')">
    <header class="fixed inset-x-0 top-0 z-50 border-b border-zinc-200/80 bg-white/80 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/80">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold">
                <span class="flex size-9 items-center justify-center rounded-lg bg-zinc-900 text-white dark:bg-white dark:text-zinc-900">
                    <x-app-logo-icon class="size-5 fill-current" />
                </span>
                <span>ConnectU</span>
            </a>

            <nav class="flex items-center gap-3">
                @auth
                    <flux:button :href="route('dashboard')" variant="primary" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:button>
                @else
                    <flux:button :href="route('login')" variant="ghost" wire:navigate>
                        {{ __('Log in') }}
                    </flux:button>
                    @if (Route::has('register'))
                        <flux:button :href="route('register')" variant="primary" wire:navigate>
                            {{ __('Get started') }}
                        </flux:button>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <main class="px-6 pt-28 pb-16">
        <section class="mx-auto max-w-6xl">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="space-y-6">
                    <flux:badge color="zinc">{{ __('Student collaboration platform') }}</flux:badge>
                    <h1 class="text-4xl font-semibold tracking-tight text-balance sm:text-5xl">
                        {{ __('Connect, study, and grow together on campus.') }}
                    </h1>
                    <p class="max-w-xl text-lg text-zinc-600 dark:text-zinc-400">
                        {{ __('ConnectU helps students find study partners, join groups, share resources, exchange skills, and give feedback — all in one place.') }}
                    </p>

                    <div class="flex flex-wrap gap-3">
                        @guest
                            <flux:button :href="route('register')" variant="primary" wire:navigate>
                                {{ __('Create your account') }}
                            </flux:button>
                            <flux:button :href="route('login')" variant="ghost" wire:navigate>
                                {{ __('Sign in') }}
                            </flux:button>
                        @else
                            <flux:button :href="route('dashboard')" variant="primary" wire:navigate>
                                {{ __('Go to dashboard') }}
                            </flux:button>
                        @endguest
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <flux:icon.users class="size-8 text-zinc-700 dark:text-zinc-200" />
                        <h2 class="mt-4 text-lg font-medium">{{ __('Peer matching') }}</h2>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Discover classmates with shared courses, interests, and availability.') }}</p>
                    </div>
                    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <flux:icon.academic-cap class="size-8 text-zinc-700 dark:text-zinc-200" />
                        <h2 class="mt-4 text-lg font-medium">{{ __('Study groups') }}</h2>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Create or join focused groups for your courses and exam prep.') }}</p>
                    </div>
                    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <flux:icon.folder class="size-8 text-zinc-700 dark:text-zinc-200" />
                        <h2 class="mt-4 text-lg font-medium">{{ __('Resource sharing') }}</h2>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Upload notes, slides, and helpful links for your peers.') }}</p>
                    </div>
                    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <flux:icon.sparkles class="size-8 text-zinc-700 dark:text-zinc-200" />
                        <h2 class="mt-4 text-lg font-medium">{{ __('Skill sharing') }}</h2>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Offer tutoring or learn from students who can teach what you need.') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layouts::guest>
