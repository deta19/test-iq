@extends('layouts.newadminapp')

@section('content')
<div class="max-w-[60%] w-full mx-auto p-6 bg-white shadow rounded-xl">
    <h2 class="text-xl font-semibold mb-4">User Table (DataTables)</h2>

    <div class="verflow-x-auto">
        <table id="userstable" class="min-w-full divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Registered</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <button onclick="closeModal()" class="absolute top-2 right-3 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Edit User</h2>

            <form id="editUserForm">
                <input type="hidden" name="id" id="editUserId">

                <div class="mb-4">
                    <label for="editUserName" class="block text-sm font-medium">Name</label>
                    <input type="text" id="editUserName" name="name" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editUserEmail" class="block text-sm font-medium">Email</label>
                    <input type="email" id="editUserEmail" name="email" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="editUserrole" class="block text-sm font-medium">Role</label>
                    <input type="text" id="editUserrole" name="role" class="mt-1 block w-full px-4 py-2 border rounded-md" required>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-600 px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
    <!--end of modal -->
</div>
@endsection
<link href="https://cdn.datatables.net/v/dt/dt-2.3.0/datatables.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.3.0/datatables.min.js"></script>

<script>
    $(document).ready(function () {
        const table = $('#userstable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('customadmin.users.data') }}',
            columns: [
                { data: 'id', className: 'px-4 py-2'},
                { data: 'name', className: 'px-4 py-2', orderable: false, searchable: true },
                { data: 'email', className: 'px-4 py-2', orderable: false, searchable: true  },
                { data: 'created_at', className: 'px-4 py-2' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-4 py-2',
                    render: function (data, type, row) {
                        return `
                            <div class="flex space-x-2">
                                <a href="#" class="edit-user text-blue-600 hover:underline text-sm" data-id="${data.id}" data-name="${data.name}" data-email="${data.email}" data-role="${data.role}">
                                    Edit
                                </a>
                                <a href="#" class="delete-user text-red-600 hover:underline text-sm" data-id="${data.id}">
                                    Delete
                                </a>
                            </div>
                        `;
                    }
                }
            ]
        });

        // Handle delete
        $(document).on('click', '.delete-user', function (e) {
            e.preventDefault();
            const userId = $(this).data('id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.post(`/dashboard/users/${userId}/delete`, {
                    _token: '{{ csrf_token() }}'
                }, function (res) {
                    table.ajax.reload();
                }).fail(function () {
                    alert('Error deleting user.');
                });
            }
        });

        // Handle edit (implement as needed)
        $(document).on('click', '.edit-user', function (e) {
            e.preventDefault();
            const userId = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const role = $(this).data('role');

            $('#editUserId').val(userId);
            $('#editUserName').val(name);
            $('#editUserEmail').val(email);
            $('#editUserrole').val(role);


            console.log(userId,name,email, role);

            document.getElementById('editUserModal').classList.remove('hidden');
            document.getElementById('editUserModal').classList.add('flex');
        });

    });

    $(document).on('submit','#editUserForm', function (e) {
        e.preventDefault();

        const userId = $('#editUserId').val();
        const formData = {
            _token: '{{ csrf_token() }}',
            name: $('#editUserName').val(),
            email: $('#editUserEmail').val(),
            role: $('#editUserrole').val()
        };

        $.ajax({
            url: `/dashboard/users/${userId}/update`,
            method: 'POST',
            data: formData,
            success: function (res) {
                closeModal();
                $('#userstable').DataTable().ajax.reload();
            },
            error: function () {
                alert('Update failed.');
            }
        });
    });

    function openModal() {
        document.getElementById('editUserModal').classList.remove('hidden');
        document.getElementById('editUserModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('editUserModal').classList.remove('flex');
        document.getElementById('editUserModal').classList.add('hidden');
    }
</script>