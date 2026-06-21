<x-connectu-layout
    :title="__('Feedback')"
    :heading="__('Feedback & Ratings')"
    :subheading="__('Recognize helpful peers and review feedback you have received.')"
>
    <div class="grid gap-8 xl:grid-cols-[minmax(0,22rem)_1fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg">{{ __('Give feedback') }}</flux:heading>

            <form action="{{ route('feedback.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf

                <flux:select name="receiver_id" :label="__('Student')" required>
                    <flux:select.option value="">{{ __('Choose a user') }}</flux:select.option>
                    @foreach ($users as $user)
                        <flux:select.option value="{{ $user->id }}" :selected="old('receiver_id') == $user->id">
                            {{ $user->name }} — {{ $user->email }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select name="rating" :label="__('Rating')" required>
                    <flux:select.option value="">{{ __('Select rating') }}</flux:select.option>
                    <flux:select.option value="1" :selected="old('rating') == '1'">1 — {{ __('Poor') }}</flux:select.option>
                    <flux:select.option value="2" :selected="old('rating') == '2'">2 — {{ __('Fair') }}</flux:select.option>
                    <flux:select.option value="3" :selected="old('rating') == '3'">3 — {{ __('Good') }}</flux:select.option>
                    <flux:select.option value="4" :selected="old('rating') == '4'">4 — {{ __('Very good') }}</flux:select.option>
                    <flux:select.option value="5" :selected="old('rating') == '5'">5 — {{ __('Excellent') }}</flux:select.option>
                </flux:select>

                <flux:textarea
                    name="comment"
                    :label="__('Comment')"
                    rows="4"
                    placeholder="{{ __('Share constructive feedback (optional)') }}"
                >{{ old('comment') }}</flux:textarea>

                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                    {{ __('Submit feedback') }}
                </flux:button>
            </form>
        </section>

        <div class="grid gap-8">
            <section>
                <flux:heading size="lg">{{ __('Feedback received') }}</flux:heading>

                @if ($feedbackReceived->isEmpty())
                    <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ __('No feedback received yet.') }}</p>
                @else
                    <div class="mt-4 grid gap-3">
                        @foreach ($feedbackReceived as $feedback)
                            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-medium">{{ $feedback->giver->name ?? __('Unknown') }}</p>
                                    <flux:badge color="green">{{ $feedback->rating }}/5</flux:badge>
                                </div>
                                @if ($feedback->comment)
                                    <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300">{{ $feedback->comment }}</p>
                                @endif
                                <p class="mt-2 text-xs text-zinc-500">{{ $feedback->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section>
                <flux:heading size="lg">{{ __('Feedback given') }}</flux:heading>

                @if ($feedbackGiven->isEmpty())
                    <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ __('No feedback given yet.') }}</p>
                @else
                    <div class="mt-4 grid gap-3">
                        @foreach ($feedbackGiven as $feedback)
                            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-medium">{{ __('To') }}: {{ $feedback->receiver->name ?? __('Unknown') }}</p>
                                    <flux:badge color="zinc">{{ $feedback->rating }}/5</flux:badge>
                                </div>
                                @if ($feedback->comment)
                                    <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300">{{ $feedback->comment }}</p>
                                @endif
                                <p class="mt-2 text-xs text-zinc-500">{{ $feedback->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-connectu-layout>
