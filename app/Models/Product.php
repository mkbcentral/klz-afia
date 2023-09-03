<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'code',
        'name',
        'conditionnement',
        'quantity','price',
        'price_abonne',
        'expirated_at',
        'id_depreciated',
    ];

    public function getQtSurvTotal($id){
        $infos=MedicationSurveillance::where('product_id',$id)->get();
        $qty=0;
        foreach ($infos as  $info) {
            $qty+=$info->qty;
        }

        return $qty;
    }

    public function day(){
        return $this->hasOne(Product::class);;
    }

    public function demandes(){
        return $this->belongsToMany(DemandeConsultation::class)->withPivot(['id','qty']);
    }

    public function specials(){
        return $this->belongsToMany(DemandeSpeciale::class)->withPivot(['id','qty']);
    }

    public function entrees(){
        return $this->belongsToMany(EntreeStock::class)->withPivot(['id','qty','price_to_by']);
    }

    public function achats(){
        return $this->belongsToMany(AchatProduct::class)->withPivot(['id','qty','price_to_by']);
    }

    public function sorties(){
        return $this->belongsToMany(SortieService::class)->withPivot(['id','qty']);
    }

    public function updateProds(){
        return $this->belongsToMany(UpdateProdSet::class)->withPivot(['id','new_price']);
    }

    public function facturePharmaAmbulant(){
        return $this->belongsToMany(FactureAbulant::class)->withPivot(['id','qty']);
    }

    public function facturesBac(){
        return $this->belongsToMany(FactureBacPharma::class)->withPivot(['id','qty']);
    }

    public function medication(){
        return $this->hasOne(MedicationService::class);
    }

    public function getEntrees($id){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->entrees as $entree) {
            $m=(new DateTime($entree->created_at))->format('Y');
            if (date('Y')!=$m) {
              $nbre= 0;
            } else {
                $nbre+=$entree->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getEntreesMonth($id,$month){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->entrees as $entree) {
            $m=(new DateTime($entree->created_at))->format('m');
            if ($m!=$month) {
              $nbre= 0;
            } else {
                $nbre+=$entree->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getSortieService($id){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->sorties as $sortie) {
            if ($sortie->is_valided==false) {
               $nbre=0;
            } else {
                $nbre+=$sortie->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getAchat($id){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->achats as $achats) {
            $nbre+=$achats->pivot->qty;
        }
        return $nbre;
    }

    public function getSortieDemande($id){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->demandes as $demande) {
            $m=(new DateTime($demande->created_at))->format('m');
            if ($m!=date('m')) {
                $nbre=0;
            } else {
                $nbre+=$demande->pivot->qty;
            }
        }
        return $nbre;
    }
    public function getSortieDemandeMontnAndYear($id,$month,$year){
        $nbre=0;
        $y="";
        $m="";
        $product=$this->find($id);
        foreach ($product->demandes as $demande) {
            $m=(new DateTime($demande->created_at))->format('m');
            $y=(new DateTime($demande->created_at))->format('Y');
            $nbre+=$demande->pivot->qty;
            if ($m==$month and $y==$year) {
                $nbre+=$demande->pivot->qty;
            } else {
                $nbre=0;
            }
        }
        return $nbre;
    }

    public function getSortieDemandeSpecMontnAndYear($id,$month,$year){
        $nbre=0;
        $y="";
        $m="";
        $product=$this->find($id);
        foreach ($product->specials as $demande) {
            $m=(new DateTime($demande->created_at))->format('m');
            $y=(new DateTime($demande->created_at))->format('Y');
            $nbre+=$demande->pivot->qty;
            if ($m==$month and $y==$year) {
                $nbre+=$demande->pivot->qty;
            } else {
                $nbre=0;
            }
        }
        return $nbre;
    }


    public function getSortieAmbulantMonthAndYear($id,$month,$year){
        $nbre=0;
        $product=$this->find($id);
        $m='';
        $y='';
        foreach ($product->facturePharmaAmbulant as $facture) {
            $m=(new DateTime($facture->created_at))->format('m');
            $y=(new DateTime($facture->created_at))->format('Y');
            if ($m==$month and $y==$year) {
               $nbre+=$facture->pivot->qty;
            } else {
                $nbre=0;
            }
        }
        return $nbre;
    }


    public function getSortieAmbulant($id){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->facturePharmaAmbulant as $demande) {
            if ($demande->isValided==false) {
               $nbre=0;
            } else {
                $nbre+=$demande->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getSortieBac($id){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->facturesBac as $demande) {
            if ($demande->isValided==false) {
               $nbre=0;
            } else {
                $nbre+=$demande->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getSortieAmbulantMonth($id,$month){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->facturePharmaAmbulant as $demande) {
            $m=date('m',strtotime($demande->created_at));
            if ($m!=$month) {
               $nbre=0;
            } else {
                $nbre+=$demande->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getSortieAmbulantDate($id,$date){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->facturePharmaAmbulant as $facture) {
            $m=(new DateTime($facture->created_at))->format('Y-m-d');
            if ($m!=$date) {
               $nbre=0;
            } else {
                $nbre+=$facture->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getSortieDemandeMonth($id,$month){
        $nbre=0;
        $product=$this->find($id);
        foreach ($product->demandes as $demande) {
            $m=date('m',strtotime($demande->created_at));
            if ($m!=$month) {
                $nbre=0;
            } else {
                $nbre+=$demande->pivot->qty;
            }
        }
        return $nbre;
    }

    public function getSortieMedicationMonth($id,$month){
        $nbre=0;
        $product=$this->find($id);
        $medications=MedicationService::where('product_id',$product->id)->get();
        foreach ($medications as $medication) {
            $m=date('m',strtotime($medication->created_at));
            if ($m!=$month) {
                $nbre=0;
            } else {
                $nbre+=$medication->qty;
            }
        }
        return $nbre;
    }
}
