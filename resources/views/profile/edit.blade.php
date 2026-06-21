<x-connectu-layout
    :title="__('My Profile')"
    :heading="__('Academic Profile')"
    :subheading="__('Tell other students about your course, interests, and availability for better peer matching.')"
>
    <form action="{{ route('connectu.profile.update') }}" method="POST" class="max-w-2xl space-y-6">
        @csrf

        <flux:input
            name="course"
            :label="__('Course / Programme')"
            :value="old('course', $profile->course ?? '')"
            required
            placeholder="{{ __('e.g. BSc Computer Science') }}"
        />

        <flux:textarea
            name="bio"
            :label="__('Bio')"
            rows="4"
            placeholder="{{ __('A short introduction about yourself') }}"
        >{{ old('bio', $profile->bio ?? '') }}</flux:textarea>

        <flux:textarea
            name="interests"
            :label="__('Interests')"
            rows="3"
            placeholder="{{ __('Comma-separated, e.g. algorithms, web development, research') }}"
        >{{ old('interests', $profile->interests ?? '') }}</flux:textarea>

        <flux:textarea
            name="skills"
            :label="__('Skills')"
            rows="3"
            placeholder="{{ __('Comma-separated, e.g. Python, public speaking, calculus') }}"
        >{{ old('skills', $profile->skills ?? '') }}</flux:textarea>

        <flux:input
            name="availability"
            :label="__('Availability')"
            :value="old('availability', $profile->availability ?? '')"
            placeholder="{{ __('e.g. Weekday evenings, Saturday mornings') }}"
        />

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">{{ __('Save profile') }}</flux:button>
            <flux:button :href="route('peer-matching.index')" variant="ghost" wire:navigate>
                {{ __('Find peers') }}
            </flux:button>
        </div>
    </form>
</x-connectu-layout>
