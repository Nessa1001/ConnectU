<x-connectu-layout
    :title="__('Skills')"
    :heading="__('Skill Sharing')"
    :subheading="__('Share what you can teach or browse skills offered by other students.')"
>
    <div class="grid gap-8 xl:grid-cols-[minmax(0,22rem)_1fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg">{{ __('Share a skill') }}</flux:heading>

            <form action="{{ route('skills.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf

                <flux:input
                    name="skill_name"
                    :label="__('Skill name')"
                    :value="old('skill_name')"
                    required
                    placeholder="{{ __('e.g. Python tutoring') }}"
                />

                <flux:textarea
                    name="description"
                    :label="__('Description')"
                    rows="3"
                    placeholder="{{ __('What can you help others with?') }}"
                >{{ old('description') }}</flux:textarea>

                <flux:select name="skill_level" :label="__('Skill level')" required>
                    <flux:select.option value="">{{ __('Select level') }}</flux:select.option>
                    <flux:select.option value="Beginner" :selected="old('skill_level') === 'Beginner'">{{ __('Beginner') }}</flux:select.option>
                    <flux:select.option value="Intermediate" :selected="old('skill_level') === 'Intermediate'">{{ __('Intermediate') }}</flux:select.option>
                    <flux:select.option value="Advanced" :selected="old('skill_level') === 'Advanced'">{{ __('Advanced') }}</flux:select.option>
                </flux:select>

                <flux:input
                    name="availability"
                    :label="__('Availability')"
                    :value="old('availability')"
                    placeholder="{{ __('When are you available to help?') }}"
                />

                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                    {{ __('Share skill') }}
                </flux:button>
            </form>
        </section>

        <section>
            <flux:heading size="lg">{{ __('Available skills') }}</flux:heading>

            @if ($skills->isEmpty())
                <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ __('No skills shared yet.') }}</p>
            @else
                <div class="mt-4 grid gap-4">
                    @foreach ($skills as $skill)
                        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                            <div class="flex flex-wrap items-center gap-2">
                                <flux:heading>{{ $skill->skill_name }}</flux:heading>
                                <flux:badge color="zinc">{{ $skill->skill_level }}</flux:badge>
                            </div>

                            @if ($skill->description)
                                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $skill->description }}</p>
                            @endif

                            <div class="mt-3 flex flex-wrap gap-4 text-sm text-zinc-600 dark:text-zinc-400">
                                <span>{{ __('Shared by') }}: {{ $skill->user->name ?? __('Unknown') }}</span>
                                @if ($skill->availability)
                                    <span>{{ __('Availability') }}: {{ $skill->availability }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-connectu-layout>
