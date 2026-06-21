@props([
    'title',
    'heading' => null,
    'subheading' => null,
])

<x-layouts::app :title="$title">
    <div class="flex flex-col gap-6">
        @if ($heading)
            <div>
                <flux:heading size="xl">{{ $heading }}</flux:heading>
                @if ($subheading)
                    <flux:subheading class="mt-1">{{ $subheading }}</flux:subheading>
                @endif
            </div>
        @endif

        @if (session('success'))
            <flux:callout variant="success" icon="check-circle" :heading="session('success')" />
        @endif

        @if ($errors->any())
            <flux:callout variant="danger" icon="x-circle" :heading="__('Please fix the errors below.')">
                <ul class="mt-2 list-disc ps-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </flux:callout>
        @endif

        {{ $slot }}
    </div>
</x-layouts::app>
