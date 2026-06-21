<x-connectu-layout
    :title="__('Messages')"
    :heading="__('Messages')"
    :subheading="__('Send messages and review your conversations with other students.')"
>
    <div class="grid gap-8 xl:grid-cols-[minmax(0,22rem)_1fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg">{{ __('Send a message') }}</flux:heading>

            <form action="{{ route('messages.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf

                <flux:select name="receiver_id" :label="__('Recipient')" required>
                    <flux:select.option value="">{{ __('Choose a user') }}</flux:select.option>
                    @foreach ($users as $user)
                        <flux:select.option value="{{ $user->id }}" :selected="old('receiver_id') == $user->id">
                            {{ $user->name }} — {{ $user->email }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:textarea
                    name="message"
                    :label="__('Message')"
                    rows="5"
                    required
                    placeholder="{{ __('Write your message here...') }}"
                >{{ old('message') }}</flux:textarea>

                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                    {{ __('Send message') }}
                </flux:button>
            </form>
        </section>

        <div class="grid gap-8">
            <section>
                <flux:heading size="lg">{{ __('Received') }}</flux:heading>

                @if ($receivedMessages->isEmpty())
                    <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ __('No received messages yet.') }}</p>
                @else
                    <div class="mt-4 grid gap-3">
                        @foreach ($receivedMessages as $message)
                            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-medium">{{ $message->sender->name ?? __('Unknown') }}</p>
                                    <span class="text-xs text-zinc-500">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300">{{ $message->message }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section>
                <flux:heading size="lg">{{ __('Sent') }}</flux:heading>

                @if ($sentMessages->isEmpty())
                    <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ __('No sent messages yet.') }}</p>
                @else
                    <div class="mt-4 grid gap-3">
                        @foreach ($sentMessages as $message)
                            <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="font-medium">{{ __('To') }}: {{ $message->receiver->name ?? __('Unknown') }}</p>
                                    <span class="text-xs text-zinc-500">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300">{{ $message->message }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-connectu-layout>
