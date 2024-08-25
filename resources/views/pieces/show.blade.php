<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-md p-6 mb-6 mx-auto max-w-4xl">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ $piece->name }}</h2>
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Tags</h3>
                <div class="mt-2">
                    @foreach ($piece->tags as $tag)
                        <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full mr-2">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Items</h3>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($piece->items as $item)
                        <li>{{ $item->name }} - <a href="{{ $item->filepath }}" class="text-blue-600 hover:underline">Download</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <a href="{{ route('pieces.index') }}" class="text-indigo-500 hover:underline mt-4 inline-block">
            Back to list
        </a>
    </div>
</x-app-layout>
