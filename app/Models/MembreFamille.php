<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembreFamille extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function fmaille(){
        return  $this->belongsTo(Famille::class,'famille_id');
    }
}
