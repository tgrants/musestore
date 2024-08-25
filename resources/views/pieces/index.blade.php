<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-md p-6 mb-6 mx-auto max-w-4xl">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Add a New Piece</h2>
        <form action="{{ route('pieces.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Piece Name</label>
                <input type="text" id="name" name="name" required class="mt-1 block w-full p-2 border rounded-md" />
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
                <select name="tags[]" id="tags" multiple class="mt-1 block w-full p-2 border rounded-md">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="py-4">
                <button type="submit" class="bg-indigo-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-400">
                    Add Piece
                </button>
            </div>
        </form>
    </div>

    <div class="mx-auto max-w-4xl">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Piece Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Tags</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pieces as $piece)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">
                            <a href="{{ route('pieces.show', $piece->id) }}" class="text-blue-600 hover:underline">
                                {{ $piece->name }}
                            </a>
                        </td>
                        <td class="px-4 py-2">
                            @foreach ($piece->tags as $tag)
                                <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full mr-2">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
