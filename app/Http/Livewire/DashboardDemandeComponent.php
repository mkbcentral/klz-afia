<?php

namespace App\Http\Livewire;

use App\Models\DemandeConsultation;
use Carbon\Carbon;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class DashboardDemandeComponent extends Component
{
    public $abonnes,$prives,$personnels,$hosp_abn,$hosp_pv,$hosp_prsnl;
    public $mois=[],$monthName,$currentMonth,$dataChart,$categorie,$valeurs;

    public function getByMonth(){
        $this->prives=DemandeConsultation::select('demande_consultations.*',
        'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
        ->whereMonth('demande_consultations.created_at',$this->monthName)
        ->get();
        $this->abonnes=DemandeConsultation::select('demande_consultations.*',
            'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',$this->monthName)
            ->get();
        $this->personnels=DemandeConsultation::select('demande_consultations.*',
            'patient_ayant_droits.Nom','patient_ayant_droits.Postnom','patient_ayant_droits.Prenom','patient_ayant_droits.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_ayant_droits','patient_ayant_droits.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',$this->monthName)
            ->get();

        $this->hosp_abn=DemandeConsultation::select('demande_consultations.*',
            'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->where('demande_consultations.is_inteneted',true)
            ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
            ->whereMonth('demande_consultations.created_at',$this->monthName)
            ->get();

        $this->hosp_pv=DemandeConsultation::select('demande_consultations.*',
            'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
            ->where('demande_consultations.is_inteneted',true)
            ->whereMonth('demande_consultations.created_at',$this->monthName)
            ->get();
        $this->hosp_prsnl=DemandeConsultation::select('demande_consultations.*',
        'patient_ayant_droits.Nom','patient_ayant_droits.Postnom','patient_ayant_droits.Prenom','patient_ayant_droits.Sexe')
        ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
        ->where('demande_consultations.is_inteneted',true)
        ->whereMonth('demande_consultations.created_at',$this->monthName)
        ->join('patient_ayant_droits','patient_ayant_droits.fiche_id','=','fiches.id')
        ->get();
    }

    public function mount(){
        $this->monthName=Carbon::now();
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
            $this->prives=DemandeConsultation::select('demande_consultations.*',
                'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
                ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
                ->whereMonth('demande_consultations.created_at',$this->monthName)
                ->get();
            $this->abonnes=DemandeConsultation::select('demande_consultations.*',
                'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
                ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
                ->whereMonth('demande_consultations.created_at',$this->monthName)
                ->get();
            $this->personnels=DemandeConsultation::select('demande_consultations.*',
                'patient_ayant_droits.Nom','patient_ayant_droits.Postnom','patient_ayant_droits.Prenom','patient_ayant_droits.Sexe')
                ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->join('patient_ayant_droits','patient_ayant_droits.fiche_id','=','fiches.id')
                ->whereMonth('demande_consultations.created_at',$this->monthName)
                ->get();

            $this->hosp_abn=DemandeConsultation::select('demande_consultations.*',
                'patient_abonnes.Nom','patient_abonnes.Postnom','patient_abonnes.Prenom','patient_abonnes.Sexe')
                ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->where('demande_consultations.is_inteneted',true)
                ->join('patient_abonnes','patient_abonnes.fiche_id','=','fiches.id')
                ->whereMonth('demande_consultations.created_at',$this->monthName)
                ->get();

            $this->hosp_pv=DemandeConsultation::select('demande_consultations.*',
                'patient_prives.Nom','patient_prives.Postnom','patient_prives.Prenom','patient_prives.Sexe')
                ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
                ->join('patient_prives','patient_prives.fiche_id','=','fiches.id')
                ->where('demande_consultations.is_inteneted',true)
                ->whereMonth('demande_consultations.created_at',$this->monthName)
                ->get();
            $this->hosp_prsnl=DemandeConsultation::select('demande_consultations.*',
            'patient_ayant_droits.Nom','patient_ayant_droits.Postnom','patient_ayant_droits.Prenom','patient_ayant_droits.Sexe')
            ->join('fiches','demande_consultations.fiche_id','=','fiches.id')
            ->where('demande_consultations.is_inteneted',true)
            ->whereMonth('demande_consultations.created_at',$this->monthName)
            ->whereYear('demande_consultations.created_at',date('Y'))
            ->join('patient_ayant_droits','patient_ayant_droits.fiche_id','=','fiches.id')
            ->get();
            $this->categorie=['init','PIVES','ABONNES','PERSONNELS','HOSPILAISES'];
            $this->valeurs=[
                            0,$this->prives->count(),
                            $this->abonnes->count(),
                            $this->personnels->count(),
                            $this->hosp_abn->count()+$this->hosp_pv->count()+$this->hosp_prsnl->count(),
                        ];
    }
    public function render()
    {
        return view('livewire.dashboard-demande-component');
    }
}
