<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function recette(){
        return $this->belongsTo(Recettes::class);
    }
}
