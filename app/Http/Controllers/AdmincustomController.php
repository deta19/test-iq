<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class AdmincustomController extends Controller
{
    public function index(): View
    {
        return view('admin.useradmin');
    }

    public function data(Request $request)
    {
        $columns = ['id', 'name', 'email', 'created_at'];

        $length = $request->input('length');
        $columnIndex = $request->input('order.0.column'); // Column index
        $columnName = $columns[$columnIndex] ?? 'id';
        $columnSortOrder = $request->input('order.0.dir', 'desc'); // asc or desc
        $searchValue = $request->input('search.value');

        $query = User::query();

        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('email', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = User::count();
        $filteredRecords = $query->count();

        $query->orderBy($columnName, $columnSortOrder);

        $users = $query->skip($request->input('start'))
                      ->take($length)
                      ->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'User updated']);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted']);
    }
}