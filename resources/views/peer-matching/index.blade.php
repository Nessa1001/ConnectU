<x-connectu-layout
    :title="__('Find Peers')"
    :heading="__('Recommended Study Partners')"
    :subheading="__('Matches are ranked by shared course, interests, skills, and availability.')"
>
    <div class="flex justify-end">
        <flux:button :href="route('connectu.profile.edit')" icon="user" variant="ghost" wire:navigate>
            {{ __('Edit my profile') }}
        </flux:button>
    </div>

    @if ($matches->isEmpty())
        <flux:callout icon="information-circle" :heading="__('No matching peers found yet.')">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Try updating your profile with more interests and skills to improve your matches.') }}
            </p>
        </flux:callout>
    @else
        <div class="grid gap-4">
            @foreach ($matches as $match)
                <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <flux:heading>{{ $match->user->name }}</flux:heading>
                                <flux:badge color="zinc">{{ $match->course }}</flux:badge>
                            </div>

                            @if ($match->bio)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $match->bio }}</p>
                            @endif

                            <div class="grid gap-2 text-sm text-zinc-600 dark:text-zinc-400 sm:grid-cols-2">
                                <p><span class="font-medium text-zinc-900 dark:text-zinc-100">{{ __('Availability') }}:</span> {{ $match->availability ?: __('Not set') }}</p>
                                <p><span class="font-medium text-zinc-900 dark:text-zinc-100">{{ __('Shared interests') }}:</span> {{ $match->shared_interests ?: __('None') }}</p>
                                <p><span class="font-medium text-zinc-900 dark:text-zinc-100">{{ __('Shared skills') }}:</span> {{ $match->shared_skills ?: __('None') }}</p>
                            </div>
                        </div>

                        <div class="flex shrink-0 flex-col items-start gap-2 sm:items-end">
                            <flux:badge color="green">{{ __('Match score') }}: {{ $match->match_score }}%</flux:badge>
                            <flux:button :href="route('messages.index')" size="sm" variant="primary" wire:navigate>
                                {{ __('Message') }}
                            </flux:button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-connectu-layout>
