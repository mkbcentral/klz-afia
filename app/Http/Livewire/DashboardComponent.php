<?php

namespace App\Http\Livewire;

use App\Charts\MonthlyUsersChart;
use App\Models\DemandeConsultation;
use App\Models\DemandeSpeciale;
use App\Models\Nursing;
use App\Models\NursingSpecial;
use App\Models\Taux;
use Carbon\Carbon;
use Livewire\Component;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class DashboardComponent extends Component
{
    public $mois=[],$monthName,$currentMonth,$dataChart;
    public $factureOcc=0,$factureCnss=0,$facturePriveHosp=0,$factureAmbulantPv;
    public $societes,$montant;
    public $specials;
    public function getByMonth(){
       $this->currentMonth=$this->monthName;
       $this->refreshAll();
    }

    public function getOcc(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;

        $total_general=0;
        $total_labo=0;$total_radio=0;$total_product=0;$total_echo=0;$total_autres=0;
                $total_sejour=0;$total_nursing=0;$total_medication=0;

        $demandes=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->join('abonnements','abonnements.id','=','patient_abonnes.abonnement_id')
        ->whereYear('demande_consultations.created_at',date('Y'))
        ->where('abonnements.name','OCC')
        ->whereMonth('demande_consultations.created_at',$this->currentMonth)
        ->get();

        $mt_cons=0;
        foreach ($demandes as $demande) {
            $mt_cons+=$demande->consultation->price_abonne*$valeur_taux;

            foreach ($demande->examenLabos as $labo) {
                $total_labo+=$labo->price_abonne*$valeur_taux*$labo->pivot->qty;
            }
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            foreach ($demande->examenRadios as $radio) {
                $total_radio+=$radio->price_abonne*$valeur_taux*$radio->pivot->qty;
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
            $nursing=Nursing::where('demande_consultation_id',$demande->id)->get();
            if ($nursing->isEmpty()) {
                # code...
            } else {
                foreach ($nursing as $n) {
                    $total_nursing+=$n->price*$valeur_taux*$n->qty;
                }
            }

            if ($demande->medications->isEmpty()) {
                # code...
            } else {
                foreach ($demande->medications as $medication) {
                    $total_medication+=$medication->product->price * $medication->qty;
                }
            }


            $total_general=$total_labo+$mt_cons+$total_product+$total_radio+$total_echo+
                            $total_sejour+$total_nursing+$total_autres+$total_medication;
        }

        return ($total_general+$this->getSpeciales("OCC"))/$valeur_taux;
    }

    public function getCnss(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;

        $total_general=0;
        $total_labo=0;$total_radio=0;$total_product=0;$total_echo=0;$total_autres=0;
                $total_sejour=0;$total_nursing=0;$total_medication=0;

        $demandes=DemandeConsultation::select('demande_consultations.*',
        'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
        ->join('abonnements','abonnements.id','=','patient_abonnes.abonnement_id')
        ->whereYear('demande_consultations.created_at',date('Y'))
        ->where('abonnements.name','CNSS')
        ->whereMonth('demande_consultations.created_at',$this->currentMonth)
        ->get();

        $mt_cons=0;
        //dd($demandes->count());
        foreach ($demandes as $demande) {
            $mt_cons+=$demande->consultation->price_abonne*$valeur_taux;

            foreach ($demande->examenLabos as $labo) {
                $total_labo+=$labo->price_abonne*$valeur_taux*$labo->pivot->qty;
            }
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            foreach ($demande->examenRadios as $radio) {
                $total_radio+=$radio->price_abonne*$valeur_taux*$radio->pivot->qty;
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
            $nursing=Nursing::where('demande_consultation_id',$demande->id)->get();
            if ($nursing->isEmpty()) {
                # code...
            } else {
                foreach ($nursing as $n) {
                    $total_nursing+=$n->price*$valeur_taux*$n->qty;
                }
            }

            if ($demande->medications->isEmpty()) {
                # code...
            } else {
                foreach ($demande->medications as $medication) {
                    $total_medication+=$medication->product->price * $medication->qty;
                }
            }

            $total_general=$total_labo+$mt_cons+$total_product+$total_radio+$total_echo+
                            $total_sejour+$total_nursing+$total_autres+$total_medication;
        }

        return ($total_general+$this->getSpeciales("CNSS"))/$valeur_taux;
    }

    public function getHospitalise(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;

        $total_general=0;
        $total_labo=0;$total_radio=0;$total_product=0;$total_echo=0;$total_autres=0;
                $total_sejour=0;$total_nursing=0;$total_medication=0;

        $demandes=DemandeConsultation::select('demande_consultations.*')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
            ->where('demande_consultations.is_inteneted',true)
            ->whereYear('demande_consultations.created_at',date('Y'))
            ->whereMonth('demande_consultations.created_at',$this->currentMonth)
            ->get();
        $mt_cons=0;

        foreach ($demandes as $demande) {
            $mt_cons+=$demande->consultation->price_prive*$valeur_taux;

            foreach ($demande->examenLabos as $labo) {
                $total_labo+=$labo->price_prive*$valeur_taux*$labo->pivot->qty;
            }
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            foreach ($demande->examenRadios as $radio) {
                $total_radio+=$radio->price_prive*$valeur_taux*$radio->pivot->qty;
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
            $nursing=Nursing::where('demande_consultation_id',$demande->id)->get();
            if ($nursing->isEmpty()) {
                # code...
            } else {
                foreach ($nursing as $n) {
                    $total_nursing+=$n->price*$valeur_taux*$n->qty;
                }
            }
            if ($demande->medications->isEmpty()) {
                # code...
            } else {
                foreach ($demande->medications as $medication) {
                    $total_medication+=$medication->product->price * $medication->qty;
                }
            }

            $total_general=$total_labo+$mt_cons+$total_product+$total_radio+$total_echo+
                            $total_sejour+$total_nursing+$total_autres+$total_medication;
        }

        return ($total_general+$this->getSpeciales("Privé"))/$valeur_taux;
    }

    public function getAmbulants(){
        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;

        $total_general=0;
        $total_labo=0;$total_radio=0;$total_product=0;$total_echo=0;$total_autres=0;
                $total_sejour=0;$total_nursing=0; $total_medication=0;

        $demandes=DemandeConsultation::select('demande_consultations.*',
            'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
            ->where('demande_consultations.is_inteneted',false)
            ->whereYear('demande_consultations.created_at',date('Y'))
            ->whereYear('demande_consultations.created_at',date('Y'))
            ->whereMonth('demande_consultations.created_at',$this->currentMonth)
            ->get();

        $mt_cons=0;
        //dd($demandes->count());
        foreach ($demandes as $demande) {
            $mt_cons+=$demande->consultation->price_prive*$valeur_taux;

            foreach ($demande->examenLabos as $labo) {
                $total_labo+=$labo->price_prive*$valeur_taux*$labo->pivot->qty;
            }
            foreach ($demande->products as $product) {
                $total_product+=$product->price*$product->pivot->qty;
            }
            foreach ($demande->examenRadios as $radio) {
                $total_radio+=$radio->price_prive*$valeur_taux*$radio->pivot->qty;
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
            $nursing=Nursing::where('demande_consultation_id',$demande->id)->get();
            if ($nursing->isEmpty()) {
                # code...
            } else {
                foreach ($nursing as $n) {
                    $total_nursing+=$n->price*$valeur_taux*$n->qty;
                }
            }

            if ($demande->medications->isEmpty()) {
                # code...
            } else {
                foreach ($demande->medications as $medication) {
                    $total_medication+=$medication->product->price * $medication->qty;
                }
            }

            $total_general=$total_labo+$mt_cons+$total_product+$total_radio+$total_echo+
                            $total_sejour+$total_nursing+$total_autres+ $total_medication;
        }



        return $total_general/$valeur_taux;
    }

    public function refreshAll(){
        //dd('ok ');
        $this->factureOcc=$this->getOcc();
        $this->factureCnss=$this->getCnss();
        $this->facturePriveHosp=$this->getHospitalise();
        $this->factureAmbulantPv=$this->getAmbulants();

        $this->societes=['Init','OCC', 'CNSS', 'Privé Hosp','Privés Ambulant'];
        $this->montant=[0,$this->factureOcc,$this->factureCnss, $this->facturePriveHosp,$this->factureAmbulantPv];

        $this->emit('refreshChart',['seriesData'=>$this->montant]);
    }

    public function mount(){
        $this->monthName=date('m');
        $this->currentMonth=$this->monthName;;

        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->refreshAll();


    }

    public function getSpeciales($type){
        $total_labo_spec=0;$total_radio_spec=0;$total_product_spec=0;$total_echo_spec=0;$total_autres_spec=0;
        $total_sejour_spec=0;$total_nursing_spec=0;$total_medication_spec=0;$total_acte_spec=0;

        $taux=Taux::find(1);
        $valeur_taux=$taux->valeur;

        $speciales=DemandeSpeciale::whereMonth('date_venue',$this->currentMonth)
        ->where('type',$type)
        ->get();
        $mt_spec=0;
        foreach ($speciales as $speciale) {
            foreach ($speciale->examenLabos as $labo) {
                $total_labo_spec+=$labo->price_abonne*$valeur_taux*$labo->pivot->qty;
            }
            foreach ($speciale->examenRadios as $radio) {
                $total_radio_spec+=$radio->price_abonne*$valeur_taux*$radio->pivot->qty;
            }
            foreach ($speciale->products as $product) {
                $total_product_spec+=$product->price*$product->pivot->qty;
            }
            foreach ($speciale->echographies as $echo) {
                $total_echo_spec+=$echo->price_abonne*$valeur_taux*$echo->pivot->qty;
            }
            foreach ($speciale->autres as $autre) {
                $total_autres_spec+=$autre->price_abonne*$valeur_taux*$autre->pivot->qty;
            }
            foreach ($speciale->sejours as $sejour) {
                $total_sejour_spec+=$sejour->price_abonne*$valeur_taux*$sejour->pivot->qty;
            }
            foreach ($speciale->actes as $acte) {
                $total_acte_spec+=$acte->price_abonne*$valeur_taux*$acte->pivot->qty;
            }
            $nursing_spec=NursingSpecial::where('demande_speciale_id',$speciale->id)->get();
            if ($nursing_spec->isEmpty()) {
                # code...
            } else {
                foreach ($nursing_spec as $n) {
                    $total_nursing_spec+=$n->price*$valeur_taux*$n->qty;
                }
            }
            $mt_spec=$total_labo_spec+$total_radio_spec+$total_product_spec+
            $total_echo_spec+$total_autres_spec+$total_sejour_spec+$total_nursing_spec+$total_acte_spec;
        }
        return $mt_spec;
    }

    public function render()
    {
            return view('livewire.dashboard-component');
    }
}
