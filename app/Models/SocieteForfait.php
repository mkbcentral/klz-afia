<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocieteForfait extends Model
{
    use HasFactory;

    public function familly(){
        return $this->hasMany(Famille::class);
    }
}
