<x-app-layout>
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
                        <input type="text" class="edit-input" value="{{ $user->password }}" data-field="password" />
                    </td>
                    <td>
                        <input type="checkbox" class="edit-input" value="{{ $user->enabled }}" data-field="enabled">
                    </td>
                    <td>
                        <input type="checkbox" class="edit-input" value="{{ $user->admin }}" data-field="admin">
                    </td>
                    <td>
                        <button class="save-btn">Save</button>
                        <button class="save-btn">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.save-btn').on('click', function() {
                var row = $(this).closest('tr');
                var userId = row.data('id');
                var name = row.find('input[data-field="name"]').val();
                var email = row.find('input[data-field="email"]').val();

                $.ajax({
                    url: '/users/' + userId,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        email: email
                    },
                    success: function(response) {
                        alert(response.success);
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message);
                    }
                });
            });
        });
    </script>
</x-app-layout>
