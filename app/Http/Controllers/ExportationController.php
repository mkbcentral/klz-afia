<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportationController extends Controller
{
    public function exprortProducts(){
        $filename='Pruducts.xlsx';
        return  Excel::download(new ProductExport,$filename);
    }
}
