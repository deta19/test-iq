<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];

    protected $listeners = ['refreshUsers' => '$refresh'];

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
        // Example: emit event to open a modal
        // $this->dispatch('editUser', $userId);
        $this->dispatch('editUser', $userId);
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
        $this->resetPage();
    }
}
