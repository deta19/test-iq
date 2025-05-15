<?php

// namespace App\Http\Livewire;
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class UserTable extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    protected $updatesQueryString = ['search'];

    protected $listeners = ['refreshUsers' => '$refresh'];
    
    public $editingUser = false;
    public $userId, $name, $email;

    #[On('editUser')]
    public function loadUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->editingUser = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->editingUser = false;
        session()->flash('message', 'User updated successfully.');
    }

    public function cancelEdit()
    {
        $this->editingUser = false;
    }
    
    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.user-table', ['users' => $users]);
    }

    public function edit($userId)
    {
        // dd($userId);
        // Example: emit event to open a modal
        // $this->emit('editUser', $userId);
        $this->dispatch('editUser', userId: $userId);
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
        $this->resetPage();
    }
}
