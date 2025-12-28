<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Wilaya;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $wilayas = Wilaya::orderBy('name')->get();
        
        return view('front.product', compact('product', 'wilayas'));
    }
}
