<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeSpeciale extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function fiche(){
        return $this->belongsTo(Fiche::class,'fiche_id');
    }

    public function signeVito(){
        return $this->hasOne(signeVito::class);
    }

    public function consultation(){
        return $this->belongsTo(Consultation::class,'consultation_id');
    }

    public function examenLabos(){
        return $this->belongsToMany(ExamenLabo::class)->withPivot(['id','qty']);
    }

    public function examenRadios(){
        return $this->belongsToMany(ExamenRx::class)->withPivot(['id','qty']);
    }

    public function echographies(){
        return $this->belongsToMany(Echographie::class)->withPivot(['id','qty']);
    }

    public function sejours(){
        return $this->belongsToMany(Sejour::class)->withPivot(['id','qty','sejour_id']);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['id','qty','posology']);
    }

    public function nursings(){
        return $this->hasMany(NursingSpecial::class);
    }

    public function autres(){
        return $this->belongsToMany(Autre::class)->withPivot(['id','qty']);
    }

    public function actes(){
        return $this->belongsToMany(ActeMedical::class)->withPivot(['id','qty']);
    }

    public function reduction(){
        return $this->hasOne(Reduction::class);
    }

    public function facturePharmaAbn(){
        return $this->hasMany(FactPharmaAbn::class);
    }

    public function medications(){
        return $this->hasMany(MedicationService::class);
    }

    public function rate(): BelongsTo
    {
        return $this->belongsTo(Rate::class, 'rate_id');
    }

    public function getTotal($id){
        $taux=Taux::find(1);
        $valeur_taux=0;
        $demande=DemandeSpeciale::find($id);
        if ($demande->rate==null) {
            $valeur_taux=$taux->valeur;
        } else {
            $valeur_taux=$demande->rate->reate;
        }



        $total_general=0;
        $total_labo=0;$total_radio=0;$total_product=0;$total_echo=0;$total_autres=0;
                $total_sejour=0;$total_nursing=0;$total_medication=0;$total_acte=0;
        $mt_cons=0;



        if ($demande->type=="Privé") {
            foreach ($demande->examenLabos as $labo) {
                $total_labo+=$labo->price_prive*$valeur_taux*$labo->pivot->qty;
            }
            foreach ($demande->examenRadios as $radio) {
                $total_radio+=$radio->price_prive*$valeur_taux*$radio->pivot->qty;
            }
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            foreach ($demande->echographies as $echo) {
                $total_echo+=$echo->price_prive*$valeur_taux*$echo->pivot->qty;
            }
            foreach ($demande->autres as $autre) {
                $total_autres+=$autre->price_prive*$valeur_taux*$autre->pivot->qty;
            }
            foreach ($demande->sejours as $sejour) {
                $total_sejour+=$sejour->price_prive*$valeur_taux*$sejour->pivot->qty;
            }
            foreach ($demande->actes as $acte) {
                $total_acte+=$acte->price_prive*$valeur_taux*$acte->pivot->qty;
            }
            $nursing=NursingSpecial::where('demande_speciale_id',$demande->id)->get();
            if ($nursing->isEmpty()) {
                # code...
            } else {
                foreach ($nursing as $n) {
                    $total_nursing+=$n->price*$valeur_taux*$n->qty;
                }
            }

        } else {
            foreach ($demande->examenLabos as $labo) {
                $total_labo+=$labo->price_abonne*$valeur_taux*$labo->pivot->qty;
            }
            foreach ($demande->examenRadios as $radio) {
                $total_radio+=$radio->price_abonne*$valeur_taux*$radio->pivot->qty;
            }
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            foreach ($demande->echographies as $echo) {
                $total_echo+=$echo->price_abonne*$valeur_taux*$echo->pivot->qty;
            }
            foreach ($demande->autres as $autre) {
                $total_autres+=$autre->price_abonne*$valeur_taux*$autre->pivot->qty;
            }
            foreach ($demande->sejours as $sejour) {
                $total_sejour+=$sejour->price_abonne*$valeur_taux*$sejour->pivot->qty;
            }
            foreach ($demande->actes as $acte) {
                $total_acte+=$acte->price_abonne*$valeur_taux*$acte->pivot->qty;
            }
            $nursing=NursingSpecial::where('demande_speciale_id',$demande->id)->get();
            if ($nursing->isEmpty()) {
                # code...
            } else {
                foreach ($nursing as $n) {
                    $total_nursing+=$n->price*$valeur_taux*$n->qty;
                }
            }


        }
        return $total_general=+$mt_cons+$total_labo+$total_radio+$total_product+
        $total_echo+$total_autres+$total_sejour+$total_nursing+$total_acte;

    }

    public function getTotalPriveRadio($id){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;
        $total_general=0;
        $total_radio=0;
        $demande=DemandeSpeciale::find($id);
        foreach ($demande->examenRadios as $radio) {
            $total_radio+=$radio->price_prive*$valeur_taux*$radio->pivot->qty;
        }
        return $total_general=+$total_radio;
    }

    public function getTotalAbonnesRadio($id){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;
        $total_general=0;
        $total_radio=0;
        $demande=DemandeSpeciale::find($id);
        foreach ($demande->examenRadios as $radio) {
            $total_radio+=$radio->price_abonne*$valeur_taux*$radio->pivot->qty;
        }
        return $total_general=+$total_radio;
    }



    public function getTotalPharma($id){

        $total_product=0;
        $demande=DemandeSpeciale::find($id);
        foreach ($demande->products as $product) {
            $total_product+=$product->price*$product->pivot->qty;
        }
        return $total_product;

    }

    public function getTotalPharmaSpecial($id){

        $total_product=0;
        $demande=DemandeSpeciale::find($id);
        foreach ($demande->products as $product) {
            $total_product+=$product->price*$product->pivot->qty;
        }
        return $total_product;

    }

}
