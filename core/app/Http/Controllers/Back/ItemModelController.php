<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemModel;

class ItemModelController extends Controller
{
    public function index()
    {
        $models = ItemModel::latest()->paginate(10);
        return view('back.item.item_model.index', compact('models'));
    }

    public function create()
    {
        return view('back.item.item_model.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        ItemModel::create($request->only(['name', 'status']));

        return redirect()
            ->route('back.item_model.index')
            ->with('success', 'Item Model created successfully.');
    }

    public function show($id)
    {
        $model = ItemModel::findOrFail($id);
        return view('back.item.item_model.show', compact('model'));
    }

    public function edit($id)
    {
        $model = ItemModel::findOrFail($id);
        return view('back.item.item_model.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $model = ItemModel::findOrFail($id);
        $model->update($request->only(['name', 'status']));

        return redirect()
            ->route('back.item_model.index')
            ->with('success', 'Item Model updated successfully.');
    }

    public function destroy($id)
    {
        $model = ItemModel::findOrFail($id);
        $model->delete();

        return redirect()
            ->route('back.item_model.index')
            ->with('success', 'Item Model deleted successfully.');
    }
}
