<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.users.partials.form', ['action' => route('system-settings.users.store')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users', 'password' => 'required']);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.users.partials.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pages.users.partials.form', ['action' => route('system-settings.users.update', $user), 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users,email,' . $user->id]);
        $user->update($request->only('name', 'email'));
        return response()->json(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function datatable(Request $request)
    {
        // Ambil parameter dari DataTables
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        // Kolom yang bisa di-search dan sort
        $columns = ['id', 'name', 'email', 'created_at'];

        // Query builder
        $query = User::query();

        // Search
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('email', 'like', "%{$searchValue}%");
            });
        }

        // Total records sebelum filter
        $totalRecords = User::count();

        // Total records setelah filter
        $totalFiltered = $query->count();

        // Order
        if (isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        }

        // Pagination
        $users = $query->skip($start)
            ->take($length)
            ->get();

        // Format data untuk DataTables
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('d M Y H:i'),
                'actions' => view('pages.users.partials.actions', compact('user'))->render()
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }
}
