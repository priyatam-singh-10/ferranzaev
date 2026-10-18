<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemColor;

class ItemColorController extends Controller
{
    public function index()
    {
        $colors = ItemColor::latest()->paginate(10);
        return view('back.item.item_color.index', compact('colors'));
    }

    public function create()
    {
        return view('back.item.item_color.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:25',
            'status' => 'required|boolean',
        ]);

        ItemColor::create($request->only(['name', 'color_code', 'status']));

        return redirect()
            ->route('back.item_color.index')
            ->with('success', 'Item Color created successfully.');
    }

    public function show($id)
    {
        $color = ItemColor::findOrFail($id);
        return view('back.item.item_color.show', compact('color'));
    }

    public function edit($id)
    {
        $color = ItemColor::findOrFail($id);
        return view('back.item.item_color.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:25',
            'status' => 'required|boolean',
        ]);

        $color = ItemColor::findOrFail($id);
        $color->update($request->only(['name', 'color_code', 'status']));

        return redirect()
            ->route('back.item_color.index')
            ->with('success', 'Item Color updated successfully.');
    }

    public function destroy($id)
    {
        $color = ItemColor::findOrFail($id);
        $color->delete();

        return redirect()
            ->route('back.item_color.index')
            ->with('success', 'Item Color deleted successfully.');
    }
}
