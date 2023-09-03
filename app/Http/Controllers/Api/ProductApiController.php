<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class ProductApiController extends Controller
{
    public function products(){
        $products=Product::orderBy('name','ASC')->get();
        return response()->json([
            'success'=>true,
            'products'=>$products
        ],200);
    }
}
