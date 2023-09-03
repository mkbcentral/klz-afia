<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function society(){
        return $this->belongsTo(SocieteForfait::class,'societe_forfait_id');
    }

    public function membres(){
        return $this->hasMany(MembreFamille::class);
    }
}
