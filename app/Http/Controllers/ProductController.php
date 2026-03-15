<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category_rel')->where('is_active', true);

        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category_rel', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::has('products')->get();

        return view('collection', compact('products', 'categories'));
    }
}
