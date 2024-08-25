<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-md p-6 mb-6 mx-auto max-w-4xl">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Add a new tag</h2>
        <form id="add-tag-form" class="flex items-center space-x-4">
            @csrf
            <div class="flex flex-col">
                <label for="new-name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Tag Name</label>
                <input type="text" id="new-name" name="name" required class="border rounded-md p-2" />
            </div>

            <div class="flex flex-col">
                <label for="new-category" class="text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                <select id="new-category" name="category_id" required class="border rounded-md p-2">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" id="add-tag-btn" class="bg-indigo-500 text-white text-sm font-semibold py-2 px-4 rounded-md hover:bg-indigo-400">Add Tag</button>
        </form>
    </div>

    <div class="mx-auto max-w-4xl">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Tag Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Category</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr data-id="{{ $tag->id }}" class="border-b border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">
                            <input type="text" class="edit-input w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md" value="{{ $tag->name }}" data-field="name" />
                        </td>
                        <td class="px-4 py-2">
                            <select class="edit-input w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md" data-field="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $tag->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <button class="save-btn bg-green-500 text-white text-sm font-semibold py-1 px-2 rounded-md hover:bg-green-400">Save</button>
                            <button class="delete-btn bg-red-500 text-white text-sm font-semibold py-1 px-2 rounded-md hover:bg-red-400">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $('#add-tag-form').on('submit', function(event) {
            event.preventDefault();

            var name = $('#new-name').val();
            var category_id = $('#new-category').val();

            $.ajax({
                url: '/tags',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    category_id: category_id,
                },
                success: function(response) {
                    alert('Tag added successfully.');
                    location.reload();
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        $('.save-btn').on('click', function() {
            var row = $(this).closest('tr');
            var tagId = row.data('id');
            var name = row.find('input[data-field="name"]').val();
            var category_id = row.find('select[data-field="category_id"]').val();

            $.ajax({
                url: '/tags/' + tagId,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    category_id: category_id,
                },
                success: function(response) {
                    alert(response.success);
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        $('.delete-btn').on('click', function() {
            var row = $(this).closest('tr');
            var tagId = row.data('id');

            $.ajax({
                url: '/tags/' + tagId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.success);
                    row.remove();
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });
    </script>
</x-app-layout>
