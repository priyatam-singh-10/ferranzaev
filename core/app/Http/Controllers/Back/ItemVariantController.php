<?php
namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\ItemVariantValue;
use App\Models\Attribute;
use Illuminate\Http\Request;

class ItemVariantController extends Controller
{
    public function index(Item $item)
    {
        return view('back.item.variant.index', [
            'item' => $item,
            'variants' => $item->variants()->with('values.option', 'values.attribute')->get(),
        ]);
    }

    public function create(Item $item)
    {
        return view('back.item.variant.create', [
            'item' => $item,
            'attributes' => Attribute::where('item_id', $item->id)->with('options')->get(),
        ]);
    }

public function store(Request $request, Item $item)
{
    $data = $request->validate([
        'image' => 'nullable|image',
        'stock' => 'required|string',
        'price_override' => 'nullable|numeric',
        'attributes' => 'required|array',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time().'_variant.'.$file->getClientOriginalExtension();
        $file->move(public_path('varients_img'), $filename);
        $data['image'] = 'varients_img/'.$filename;
    }
 
    // Create variant
    $variant = $item->variants()->create([
        'image' => $data['image'] ?? null,
        'stock' => $data['stock'],
        'price_override' => $data['price_override'] ?? null,
    ]);
          
   if ($request->has('attributes')) {
        foreach ($request->attributes as $attribute_id => $attribute_option_id) {
            $variant->values()->create([
                'attribute_id' => $attribute_id,
                'attribute_option_id' => $attribute_option_id,
            ]);
        }
    }

    return redirect()->route('back.variant.index', $item->id)->withSuccess('Variant created successfully.');
}

    public function edit(Item $item, ItemVariant $variant)
    {
        return view('back.item.variant.edit', [
            'item' => $item,
            'variant' => $variant,
            'attributes' => Attribute::where('item_id', $item->id)->with('options')->get(),
        ]);
    }

   public function update(Request $request, Item $item, ItemVariant $variant)
{
    $data = $request->validate([
        'image' => 'nullable|image',
        'stock' => 'required|string',
        'price_override' => 'nullable|numeric',
        'attributes' => 'required|array',
    ]);

    // Handle image upload if a new file is provided
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time().'_variant.'.$file->getClientOriginalExtension();
        $file->move(public_path('varients_img'), $filename);
        $data['image'] = 'varients_img/'.$filename;
    }
       //dd($request, $item);
    // Update variant
    $variant->update($data);

    // Update variant attribute selections
  $variant->values()->delete();
  $attributes = $request->input('attributes', []);

    if (!empty($attributes)) {
        foreach ($attributes as $attribute_id => $attribute_option_id) {
            $variant->values()->create([
                'attribute_id' => $attribute_id,
                'attribute_option_id' => $attribute_option_id,
            ]);
        }
    }

    return redirect()->route('back.variant.index', $item->id)->withSuccess('Variant updated successfully.');
}

    public function destroy(Item $item, ItemVariant $variant)
    {
        $variant->values()->delete();
        $variant->delete();
        return redirect()->route('back.variant.index', $item->id)->withSuccess('Variant deleted successfully.');
    }
}
