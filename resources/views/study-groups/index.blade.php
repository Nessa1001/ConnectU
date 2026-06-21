<x-connectu-layout
    :title="__('Study Groups')"
    :heading="__('Study Groups')"
    :subheading="__('Join existing groups or create a new one for your course.')"
>
    <div class="flex justify-end">
        <flux:button :href="route('study-groups.create')" icon="plus" variant="primary" wire:navigate>
            {{ __('Create group') }}
        </flux:button>
    </div>

    @if ($studyGroups->isEmpty())
        <flux:callout icon="information-circle" :heading="__('No study groups yet.')">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Be the first to create a group for your course.') }}</p>
        </flux:callout>
    @else
        <div class="grid gap-4">
            @foreach ($studyGroups as $group)
                @php
                    $memberCount = $group->members->count();
                    $isMember = $group->members->contains(fn ($member) => $member->user_id === auth()->id());
                    $isFull = $memberCount >= $group->max_members;
                @endphp

                <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <flux:heading>{{ $group->group_name }}</flux:heading>
                                <flux:badge color="zinc">{{ $group->course }}</flux:badge>
                            </div>

                            @if ($group->description)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $group->description }}</p>
                            @endif

                            <div class="flex flex-wrap gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                                <span>{{ __('Created by') }}: {{ $group->user->name ?? __('Unknown') }}</span>
                                <span>{{ __('Members') }}: {{ $memberCount }}/{{ $group->max_members }}</span>
                                @if ($group->meeting_schedule)
                                    <span>{{ __('Schedule') }}: {{ $group->meeting_schedule }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if ($isMember)
                                <flux:badge color="green">{{ __('Joined') }}</flux:badge>
                            @elseif ($isFull)
                                <flux:badge color="red">{{ __('Full') }}</flux:badge>
                            @else
                                <form action="{{ route('study-groups.join', $group) }}" method="POST">
                                    @csrf
                                    <flux:button type="submit" variant="primary" size="sm">
                                        {{ __('Join group') }}
                                    </flux:button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-connectu-layout>
