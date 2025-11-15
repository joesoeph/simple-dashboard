<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.roles.partials.form', [
            'action' => route('roles.store'),
            'role' => null,
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('roles')->where('guard_name', $request->guard_name),
            ],
            'guard_name' => 'required|in:web',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create($validated);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('pages.roles.partials.show', [
            'role' => $role,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('pages.roles.partials.form', [
            'action' => route('roles.update', $role),
            'role' => $role,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('roles')
                    ->where('guard_name', $request->guard_name)
                    ->ignore($role->id),
            ],
            'guard_name' => 'required|in:web',
            'permissions' => 'nullable|array',
        ]);

        $role->update($validated);
        $role->syncPermissions($validated['permissions'] ?? []);

        return response()->json(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
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
        $columns = ['id', 'name', 'guard_name', 'created_at'];

        // Query builder
        $query = Role::query();

        // Search
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%");
            });
        }

        // Total records sebelum filter
        $totalRecords = Role::count();

        // Total records setelah filter
        $totalFiltered = $query->count();

        // Order
        if (isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        }

        // Pagination
        $roles = $query->skip($start)
            ->take($length)
            ->get();

        // Format data untuk DataTables
        $data = [];
        foreach ($roles as $role) {
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permission_count' => $role->permissions->count(),
                'created_at' => $role->created_at->format('d M Y H:i'),
                'actions' => view('pages.roles.partials.actions', compact('role'))->render()
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
