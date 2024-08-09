<div class="btn-group">
    @if ($user->role != 'User')
        <button class="btn btn-sm btn-primary" onclick="editUser({{ $user->id }})">Edit</button>
        @if (Auth::user()->id != $user->id)
            <button class="btn btn-sm btn-danger delete-button" onclick="deleteUser({{ $user->id }})">Delete</button>
        @endif
    @endif
</div>
