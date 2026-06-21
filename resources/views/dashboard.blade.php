<x-connectu-layout
    :title="__('Dashboard')"
    :heading="__('Welcome back, :name', ['name' => auth()->user()->name])"
    :subheading="__('Choose a feature to get started with your learning community.')"
>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <a href="{{ route('connectu.profile.edit') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.user class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('My Profile') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Set your course, interests, skills, and availability.') }}</p>
        </a>

        <a href="{{ route('peer-matching.index') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.users class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('Find Peers') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Get matched with students who share your goals.') }}</p>
        </a>

        <a href="{{ route('study-groups.index') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.academic-cap class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('Study Groups') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Browse groups or create one for your course.') }}</p>
        </a>

        <a href="{{ route('messages.index') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.chat-bubble-left-right class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('Messages') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Send and read messages with other students.') }}</p>
        </a>

        <a href="{{ route('resources.index') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.folder class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('Resources') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Share files and links with your study community.') }}</p>
        </a>

        <a href="{{ route('skills.index') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.sparkles class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('Skills') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Offer or discover skills you can teach or learn.') }}</p>
        </a>

        <a href="{{ route('feedback.index') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.star class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('Feedback') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Rate peers and read feedback you have received.') }}</p>
        </a>

        <a href="{{ route('profile.edit') }}" wire:navigate class="group rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-zinc-300 hover:shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600">
            <flux:icon.cog class="size-6 text-zinc-700 dark:text-zinc-200" />
            <h2 class="mt-3 font-medium">{{ __('Account Settings') }}</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Manage your account, security, and team preferences.') }}</p>
        </a>
    </div>
</x-connectu-layout>
