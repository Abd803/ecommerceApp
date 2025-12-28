<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'main_image' => 'required|image|max:2048',
            'secondary_images.*' => 'image|max:2048',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'available_models' => 'nullable|array',
            'available_models.*' => 'nullable|string',
        ]);

        $data = $request->except(['main_image', 'secondary_images']);
        $data['slug'] = Str::slug($request->name);
        
        // Handle Main Image
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        // Handle Secondary Images
        if ($request->hasFile('secondary_images')) {
            $images = [];
            foreach ($request->file('secondary_images') as $image) {
                $images[] = $image->store('products', 'public');
            }
            $data['secondary_images'] = $images;
        }

        // Clean features array
        if (isset($data['features'])) {
            $data['features'] = array_filter($data['features'], fn($value) => !is_null($value) && $value !== '');
        }

        // Clean models array
        if (isset($data['available_models'])) {
            $data['available_models'] = array_filter($data['available_models'], fn($value) => !is_null($value) && $value !== '');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'main_image' => 'nullable|image|max:2048',
            'secondary_images.*' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'available_models' => 'nullable|array',
            'available_models.*' => 'nullable|string',
        ]);

        $data = $request->except(['main_image', 'secondary_images']);
        
        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        if ($request->hasFile('secondary_images')) {
            $images = $product->secondary_images ?? [];
            foreach ($request->file('secondary_images') as $image) {
                $images[] = $image->store('products', 'public');
            }
            $data['secondary_images'] = $images;
        }
        
        if (isset($data['features'])) {
            $data['features'] = array_filter($data['features'], fn($value) => !is_null($value) && $value !== '');
        }

        // Clean models array
        if (isset($data['available_models'])) {
            $data['available_models'] = array_filter($data['available_models'], fn($value) => !is_null($value) && $value !== '');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé.');
    }
}
