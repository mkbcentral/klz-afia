<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recettes extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function depenses(){
        return $this->hasMany(Depense::class);
    }

    public function getDepensesCDF($id){
        $mt=0;
        $recette=Recettes::find($id);

        foreach ($recette->depenses as $rcte) {
           if ($rcte->devise=="CDF") {
                $mt+=$rcte->mt;
           }
        }
        //dd($mt);
        return $mt;
    }
    public function getDepensesUSD($id){
        $mt=0;
        $recette=Recettes::find($id);

        foreach ($recette->depenses as $rcte) {
           if ($rcte->devise=="USD") {
                $mt+=$rcte->mt;
           }
        }

        return $mt;
    }
}
