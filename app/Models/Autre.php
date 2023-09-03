<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autre extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function demandes(){
        return $this->belongsToMany(DemandeConsultation::class);
    }
}
