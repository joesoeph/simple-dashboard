<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.permissions.partials.form', ['action' => route('system-settings.permissions.store')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('permissions')->where('guard_name', $request->guard_name),
            ],
            'guard_name' => 'required|in:web',
        ]);
        Permission::create($validated);
        return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return view('pages.permissions.partials.show', ['permission' => $permission]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('pages.permissions.partials.form', ['action' => route('system-settings.permissions.update', $permission), 'permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('permissions')
                    ->where('guard_name', $request->guard_name)
                    ->ignore($permission->id),
            ],
            'guard_name' => 'required|in:web',
        ]);
        $permission->update($validated);
        return response()->json(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
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
        $query = Permission::query();

        // Search
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%");
            });
        }

        // Total records sebelum filter
        $totalRecords = Permission::count();

        // Total records setelah filter
        $totalFiltered = $query->count();

        // Order
        if (isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        }

        // Pagination
        $permissions = $query->skip($start)
            ->take($length)
            ->get();

        // Format data untuk DataTables
        $data = [];
        foreach ($permissions as $permission) {
            $data[] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
                'created_at' => $permission->created_at->format('d M Y H:i'),
                'actions' => view('pages.permissions.partials.actions', compact('permission'))->render()
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
