<x-connectu-layout
    :title="__('Create Study Group')"
    :heading="__('Create Study Group')"
    :subheading="__('Set up a new group so classmates can study together.')"
>
    <form action="{{ route('study-groups.store') }}" method="POST" class="max-w-2xl space-y-6">
        @csrf

        <flux:input
            name="group_name"
            :label="__('Group name')"
            :value="old('group_name')"
            required
            placeholder="{{ __('e.g. Data Structures Study Circle') }}"
        />

        <flux:input
            name="course"
            :label="__('Course')"
            :value="old('course')"
            required
            placeholder="{{ __('e.g. CSC 301') }}"
        />

        <flux:textarea
            name="description"
            :label="__('Description')"
            rows="4"
            placeholder="{{ __('What will this group focus on?') }}"
        >{{ old('description') }}</flux:textarea>

        <flux:input
            name="max_members"
            type="number"
            min="2"
            max="100"
            :label="__('Maximum members')"
            :value="old('max_members', 10)"
            required
        />

        <flux:input
            name="meeting_schedule"
            :label="__('Meeting schedule')"
            :value="old('meeting_schedule')"
            placeholder="{{ __('e.g. Tuesdays & Thursdays, 6–8 PM') }}"
        />

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">{{ __('Create group') }}</flux:button>
            <flux:button :href="route('study-groups.index')" variant="ghost" wire:navigate>
                {{ __('Cancel') }}
            </flux:button>
        </div>
    </form>
</x-connectu-layout>
