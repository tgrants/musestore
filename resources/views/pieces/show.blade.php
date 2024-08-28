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
                <ul id="item-list" class="mt-2 list-disc list-inside">
                    @foreach ($piece->items as $item)
                        <li id="item-{{ $item->id }}">
                            {{ $item->name }} - 
                            <a href="{{ $item->filepath }}" class="text-blue-600 hover:underline">Download</a>
                            @if(auth()->check() && auth()->user()->admin)
                                <button class="delete-item-btn text-red-500 ml-2" data-id="{{ $item->id }}">Delete</button>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            @if(auth()->check() && auth()->user()->admin)
                <form id="upload-item-form" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="item-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item Name</label>
                        <input type="text" id="item-name" name="name" required class="mt-1 block w-full p-2 border rounded-md" />
                    </div>
                    <div>
                        <label for="item-file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload File</label>
                        <input type="file" id="item-file" name="file" required class="mt-1 block w-full p-2 border rounded-md" />
                    </div>
                    <button type="submit" class="bg-indigo-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-400">
                        Add Item
                    </button>
                </form>

                <button id="delete-piece-btn" class="bg-red-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-red-400 mt-4">
                    Delete Piece
                </button>
            @endif
        </div>

        <a href="{{ route('pieces.index') }}" class="text-indigo-500 hover:underline mt-4 inline-block">
            Back to list
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle Item Deletion
            $('.delete-item-btn').on('click', function() {
                var itemId = $(this).data('id');
                $.ajax({
                    url: '/items/' + itemId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#item-' + itemId).remove();
                        alert('Item deleted successfully.');
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            });

            $('#delete-piece-btn').on('click', function() {
                $.ajax({
                    url: '{{ route("pieces.destroy", $piece->id) }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Piece deleted successfully.');
                        window.location.href = '{{ route("pieces.index") }}';
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            });

            $('#upload-item-form').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route("items.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#item-list').append(`
                            <li id="item-${response.item.id}">
                                ${response.item.name} - 
                                <a href="${response.item.filepath}" class="text-blue-600 hover:underline">Download</a>
                                <button class="delete-item-btn text-red-500 ml-2" data-id="${response.item.id}">Delete</button>
                            </li>
                        `);
                        alert('Item added successfully.');
                        $('#upload-item-form')[0].reset();
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            });
        });
    </script>
</x-app-layout>
