<div class="flex space-x-2">
    <button class="text-blue-600 hover:underline" onclick="editUser({{ $user->id }})">Edit</button>
    @if(auth()->user()->role === 'admin')
        <button class="text-red-600 hover:underline" onclick="deleteUser({{ $user->id }})">Delete</button>
    @endif
</div>