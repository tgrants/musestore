<x-app-layout>
    <!--
    <div>
        <h2>Add New User</h2>
        <form id="add-user-form">
            @csrf
            <label for="new-name">Name:</label>
            <input type="text" id="new-name" name="name" required />

            <label for="new-password">Password:</label>
            <input type="password" id="new-password" name="password" required />

            <label for="new-enabled">Enabled:</label>
            <input type="checkbox" id="new-enabled" name="enabled" checked />

            <label for="new-admin">Admin:</label>
            <input type="checkbox" id="new-admin" name="admin" />

            <button type="submit" id="add-user-btn">Add User</button>
        </form>
    </div>
    -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Enabled</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr data-id="{{ $user->id }}">
                    <td>
                        <input type="text" class="edit-input" value="{{ $user->name }}" data-field="name" />
                    </td>
                    <td>
                        <input type="password" class="edit-input" data-field="password" />
                    </td>
                    <td>
                        <input type="checkbox" class="edit-input" data-field="enabled" {{ $user->enabled ? 'checked' : '' }}>
                    </td>
                    <td>
                        <input type="checkbox" class="edit-input" data-field="admin" {{ $user->admin ? 'checked' : '' }}>
                    </td>
                    <td>
                        <button class="save-btn">Save</button>
                        <button class="delete-btn">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
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
