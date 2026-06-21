<x-connectu-layout
    :title="__('Resources')"
    :heading="__('Learning Resources')"
    :subheading="__('Upload study materials or share helpful links with your peers.')"
>
    <div class="grid gap-8 xl:grid-cols-[minmax(0,22rem)_1fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:heading size="lg">{{ __('Upload resource') }}</flux:heading>

            <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf

                <flux:input
                    name="title"
                    :label="__('Title')"
                    :value="old('title')"
                    required
                />

                <flux:input
                    name="course"
                    :label="__('Course')"
                    :value="old('course')"
                    required
                />

                <flux:textarea
                    name="description"
                    :label="__('Description')"
                    rows="3"
                >{{ old('description') }}</flux:textarea>

                <div>
                    <flux:label>{{ __('Upload file') }}</flux:label>
                    <input
                        type="file"
                        name="resource_file"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png"
                        class="mt-2 block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-zinc-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white dark:text-zinc-300 dark:file:bg-white dark:file:text-zinc-900"
                    />
                    <p class="mt-1 text-xs text-zinc-500">{{ __('PDF, Word, PowerPoint, text, or image up to 10 MB.') }}</p>
                </div>

                <flux:input
                    name="resource_link"
                    type="url"
                    :label="__('Resource link')"
                    :value="old('resource_link')"
                    placeholder="https://"
                />

                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                    {{ __('Upload resource') }}
                </flux:button>
            </form>
        </section>

        <section>
            <flux:heading size="lg">{{ __('Available resources') }}</flux:heading>

            @if ($resources->isEmpty())
                <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ __('No resources uploaded yet.') }}</p>
            @else
                <div class="mt-4 grid gap-4">
                    @foreach ($resources as $resource)
                        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                            <div class="flex flex-wrap items-center gap-2">
                                <flux:heading>{{ $resource->title }}</flux:heading>
                                <flux:badge color="zinc">{{ $resource->course }}</flux:badge>
                            </div>

                            @if ($resource->description)
                                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $resource->description }}</p>
                            @endif

                            <div class="mt-3 flex flex-wrap gap-4 text-sm">
                                @if ($resource->file_path)
                                    <flux:link :href="asset('storage/' . $resource->file_path)" target="_blank">
                                        {{ __('Download file') }}
                                    </flux:link>
                                @endif

                                @if ($resource->resource_link)
                                    <flux:link :href="$resource->resource_link" target="_blank">
                                        {{ __('Open link') }}
                                    </flux:link>
                                @endif
                            </div>

                            <p class="mt-3 text-xs text-zinc-500">
                                {{ __('Uploaded by') }} {{ $resource->user->name ?? __('Unknown') }}
                                · {{ $resource->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-connectu-layout>
