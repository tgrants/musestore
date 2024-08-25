<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-md p-6 mb-6 mx-auto max-w-4xl">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Add a New Category</h2>
        <form id="add-category-form" class="flex items-center space-x-4">
            @csrf
            <div class="flex flex-col">
                <label for="new-category-name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                <input type="text" id="new-category-name" name="name" required class="border rounded-md p-2" />
            </div>

            <button type="submit" id="add-category-btn" class="bg-indigo-500 text-white text-sm font-semibold py-2 px-4 rounded-md hover:bg-indigo-400">Add Category</button>
        </form>
    </div>

    <div class="mx-auto max-w-4xl">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Category Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr data-id="{{ $category->id }}" class="border-b border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">
                            <input type="text" class="edit-input w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md" value="{{ $category->name }}" data-field="name" />
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
        $('#add-category-form').on('submit', function(event) {
            event.preventDefault();

            var name = $('#new-category-name').val();

            $.ajax({
                url: '/categories',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name
                },
                success: function(response) {
                    alert('Category added successfully.');
                    location.reload();
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        $('.save-btn').on('click', function() {
            var row = $(this).closest('tr');
            var categoryId = row.data('id');
            var name = row.find('input[data-field="name"]').val();

            $.ajax({
                url: '/categories/' + categoryId,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name
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
            var categoryId = row.data('id');

            $.ajax({
                url: '/categories/' + categoryId,
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
