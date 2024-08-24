<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow-md p-6 mb-6 mx-auto max-w-4xl">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 text-center">Add a new user</h2>
        <form id="add-user-form" class="flex items-center space-x-4">
            @csrf
            <div class="flex flex-col">
                <label for="new-name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" id="new-name" name="name" required class="border rounded-md p-2" />
            </div>

            <div class="flex flex-col">
                <label for="new-password" class="text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input type="password" id="new-password" name="password" required class="border rounded-md p-2" />
            </div>

            <div class="flex items-center space-x-2">
                <input type="checkbox" id="new-enabled" name="enabled" checked class="h-4 w-4" />
                <label for="new-enabled" class="text-sm font-medium text-gray-700 dark:text-gray-300">Enabled</label>
            </div>

            <div class="flex items-center space-x-2">
                <input type="checkbox" id="new-admin" name="admin" class="h-4 w-4" />
                <label for="new-admin" class="text-sm font-medium text-gray-700 dark:text-gray-300">Admin</label>
            </div>

            <button type="submit" id="add-user-btn" class="bg-indigo-500 text-white text-sm font-semibold py-2 px-4 rounded-md hover:bg-indigo-400">Add User</button>
        </form>
    </div>

    <div class="mx-auto max-w-4xl">
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Password</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Enabled</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Admin</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr data-id="{{ $user->id }}" class="border-b border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">
                            <input type="text" class="edit-input w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md" value="{{ $user->name }}" data-field="name" />
                        </td>
                        <td class="px-4 py-2">
                            <input type="password" class="edit-input w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md" data-field="password" />
                        </td>
                        <td class="px-4 py-2">
                            <input type="checkbox" class="edit-input" data-field="enabled" {{ $user->enabled ? 'checked' : '' }}>
                        </td>
                        <td class="px-4 py-2">
                            <input type="checkbox" class="edit-input" data-field="admin" {{ $user->admin ? 'checked' : '' }}>
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
        $('#add-user-form').on('submit', function(event) {
            event.preventDefault();

            var name = $('#new-name').val();
            var password = $('#new-password').val();
            var enabled = $('#new-enabled').is(':checked') ? 1 : 0;
            var admin = $('#new-admin').is(':checked') ? 1 : 0;

            $.ajax({
                url: '/users',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    password: password,
                    enabled: enabled,
                    admin: admin
                },
                success: function(response) {
                    alert('User added successfully.');
                    location.reload();
                },
                error: function(response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });

        $('.save-btn').on('click', function() {
            var row = $(this).closest('tr');
            var userId = row.data('id');
            var name = row.find('input[data-field="name"]').val();
            var password = row.find('input[data-field="password"]').val();
            var enabled = row.find('input[data-field="enabled"]').is(':checked') ? 1 : 0;
            var admin = row.find('input[data-field="admin"]').is(':checked') ? 1 : 0;

            $.ajax({
                url: '/users/' + userId,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    password: password,
                    enabled: enabled,
                    admin: admin
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
            var userId = row.data('id');

            $.ajax({
                url: '/users/' + userId,
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
