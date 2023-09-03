<?php

namespace Database\Seeders;

use App\Models\DemandeConsultation;
use Illuminate\Database\Seeder;

class ChangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demandes = DemandeConsultation::select('demande_consultations.*')
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', '02')
            ->where('patient_abonnes.abonnement_id', 1)
            ->whereYear('demande_consultations.created_at', '2023')
            ->orderBy('demande_consultations.numero', 'ASC')
            ->get();
        dd($demandes);
        /*
        foreach ($demandes as $demande) {
            if( $demande->rate_id==null){
                $demande->rate_id=3;
                $demande->update();
            }
        }
        dd('Action successfully !');
        */

    }
}
