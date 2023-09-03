<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DataPharmaController extends Controller
{
    public function getProds($month,$year){
        $pproducts = Product::orderBy('name','ASC')->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('data',compact(['pproducts','month','year']));
        return $pdf->stream();
    }
}
