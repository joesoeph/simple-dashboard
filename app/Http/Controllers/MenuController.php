<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function reorder(Request $request)
    {
        $tree = $request->tree;

        $order = 1;

        $updateTree = function ($items, $parentId = null) use (&$updateTree, &$order) {
            foreach ($items as $item) {

                Menu::where('id', $item['id'])->update([
                    'parent_id' => $parentId,
                    'order'     => $order++,
                ]);

                if (!empty($item['children'])) {
                    $updateTree($item['children'], $item['id']);
                }
            }
        };

        $updateTree($tree);

        return response()->json(['success' => true]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menusManagement = Menu::whereNull('parent_id')->orderBy('order')->with('children')->get();
        return view('pages.menus.index', compact('menusManagement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.menus.partials.form', [
            'action' => route('system-settings.menus.store'),
            'role' => null,
            'parents' => Menu::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'label' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'route' => 'required|string',
            'parent_id' => 'nullable|integer|exists:menus,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $validated['is_active'] ?? 0;

        Menu::create($validated);

        return redirect()
            ->route('system-settings.menus.index')
            ->with('success', 'Menu created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('pages.menus.partials.show', [
            'menu' => $menu,
            'parents' => Menu::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('pages.menus.partials.form', [
            'action' => route('system-settings.menus.update', $menu),
            'menu' => $menu,
            'parents' => Menu::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'label' => 'required|string|max:100',
            'icon' => 'nullable|string|max:50',
            'route' => 'required|string',
            'parent_id' => 'nullable|integer|exists:menus,id',
            'order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $validated['is_active'] ?? 0;

        $menu->update($validated);

        return redirect()
            ->route('system-settings.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
