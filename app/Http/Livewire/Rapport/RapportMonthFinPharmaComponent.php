<?php

namespace App\Http\Livewire\Rapport;

use App\Models\DemandeConsultation;
use App\Models\DemandeSpeciale;
use App\Models\FactureAbulant;
use Livewire\Component;
use PhpParser\Builder\Function_;

class RapportMonthFinPharmaComponent extends Component
{
    public $mois,$currentDate;
    public $mt_prive_pharma,$mt_ambulant,$mt_pharma_abn,$mt_pharma_spectial;
    public function mount(){
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->currentDate=date('m');

    }

    public function getCurrentDate(){
       // dd($this->currentDate);
    }

    public function getPrive(){
        $total1=0;
        $total2=0;
        $demandes=DemandeConsultation::join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
                ->where('fiches.type','Privé')
                ->whereMonth('demande_consultations.created_at',$this->currentDate)
                ->get();
                //dd($demandes);
        foreach ($demandes as $demande) {
            if ($demande->products->isEmpty()) {
            }else{

                foreach ($demande->products as $product) {
                    $total1+=$product->pivot->qty*$product->price;
                }
            }

            if ($demande->medications->isEmpty()) {
            }else{
                foreach ($demande->medications as $medication) {
                    $total2+=$medication->product->price * $medication->qty;
                }
            }
        }

        return $total1+$total2;

    }

    public function getAbonnees(){
        $total1=0;
        $total2=0;
        $demandes=DemandeConsultation::join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
                ->where('fiches.type','Abonné')
                ->whereMonth('demande_consultations.created_at',$this->currentDate)
                ->get();
                //dd($demandes);
        foreach ($demandes as $demande) {
            if ($demande->products->isEmpty()) {
            }else{

                foreach ($demande->products as $product) {
                    $total1+=$product->pivot->qty*$product->price;
                }
            }

            if ($demande->medications->isEmpty()) {
            }else{
                foreach ($demande->medications as $medication) {
                    $total2+=$medication->product->price * $medication->qty;
                }
            }
        }

        return $total1+$total2;

    }

    public function getAmbulant(){
        $total=0;
        $facture=FactureAbulant::whereMonth('created_at',$this->currentDate)->get();
        foreach ($facture as $facture) {
            if ($facture->products->isEmpty()) {
            }else{
                foreach ($facture->products as $product) {
                    $total+=$product->pivot->qty*$product->price;
                }
            }

        }
        return $total;

    }

    public function getSpecial(){
        $total=0;
        $facture=DemandeSpeciale::whereMonth('date_venue',$this->currentDate)->get();
        foreach ($facture as $facture) {
            if ($facture->products->isEmpty()) {
            }else{
                foreach ($facture->products as $product) {
                    $total+=$product->pivot->qty*$product->price;
                }
            }

        }
        return $total;

    }
    public function render()
    {
        $this->mt_prive_pharma=$this->getPrive();
        $this->mt_ambulant=$this->getAmbulant();
        $this->mt_pharma_abn=$this->getAbonnees();
        $this->mt_pharma_spectial=$this->getSpecial();

        return view('livewire.rapport.rapport-month-fin-pharma-component');
    }
}
