<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\ActeMedical;
use App\Models\Autre;
use App\Models\Consultation;
use App\Models\DemandeConsultation;
use App\Models\DemandeSpeciale;
use App\Models\Echographie;
use App\Models\ExamenLabo;
use App\Models\ExamenRx;
use App\Models\FactPharmaAbn;
use App\Models\FactureAbulant;
use App\Models\FactureBacPharma;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Sejour;
use App\Models\Service;
use App\Models\SortieService;
use App\Models\Taux;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PrinterController extends Controller
{
    //FACTURATION
    public function printFactPrive($date)
    {
        $valeur_taux = 0;
        $demande = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_prives.Nom',
            'patient_prives.Postnom',
            'patient_prives.Prenom',
            'patient_prives.Sexe'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_prives', 'patient_prives.fiche_id', '=', 'fiches.id')
            ->where('demande_consultations.id', $date)
            ->first();
        if ($demande->rate == null) {
            $valeur_taux = 2000;
        }else{
            $valeur_taux = $demande->rate->reate;
        }

        $datePrinter = date('d-m-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-facture-prives', compact(['valeur_taux', 'demande', 'datePrinter']));
        return $pdf->stream();
    }

    public function printFactAbonnes($id)
    {
        $rate = Rate::where('is_active', true)->first();
        $valeur_taux = 0;
        $demande = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->where('demande_consultations.id', $id)
            ->first();
        $valeur_taux = 0;
        if ($demande->rate == null) {
            $rate = Rate::where('is_active', true)->first();
            $$valeur_taux = 2000;
        } else {
            $valeur_taux = $demande->rate->reate;
        }
        $datePrinter = date('d-m-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-facture-abonnes', compact(['valeur_taux', 'demande', 'datePrinter']));
        return $pdf->stream();
    }
    //ALL FACFURES MENSUELLES
    public function printAllFactAbonnes($month, $abonnement, $year)
    {
        $rate = Rate::where('is_active', true)->first();
        $valeur_taux = $rate->rate;
        $demandes = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', $month)
            ->where('patient_abonnes.abonnement_id', $abonnement)
            ->orderBy('demande_consultations.numero', 'ASC')
            ->whereYear('demande_consultations.created_at', $year)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-facture-abonnes-all', compact(['valeur_taux', 'demandes']));
        return $pdf->stream();
    }

    public function printFactAllPeriode($dateFrom, $dateTo, $abonnement)
    {
        $rate = Rate::where('is_active', true)->first();
        $valeur_taux = $rate->rate;
        $demandes = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->where('patient_abonnes.abonnement_id', $abonnement)
            ->whereBetween('demande_consultations.created_at', [$dateFrom, $dateTo])
            ->orderBy('demande_consultations.numero', 'ASC')
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-facture-abonnes-all', compact(['valeur_taux', 'demandes']));
        return $pdf->stream();
    }

    public function printFactSpeciale($id)
    {
        $rate = Rate::where('is_active', true)->first();
        $valeur_taux = 0;
        $demande = DemandeSpeciale::where('demande_speciales.id', $id)
            ->first();
        if ($demande->rate != null) {
            $valeur_taux = $demande->rate->reate;
        } else {
            $valeur_taux = 2000;
        }

        $datePrinter = date('d-m-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-facture-speciale', compact(['valeur_taux', 'demande', 'datePrinter']));
        return $pdf->stream();
    }
    //RELEVE MENSUEL
    public function printRevleMonth($entete, $month, $abonnement, $mtLetter, $year)
    {
        $valeur_taux = 0;
        switch ($month) {
            case '01':
                $valeur_taux = 2000;
                break;
            case '02':
                $valeur_taux = 2000;
                break;
            case '03':
                $valeur_taux = 2000;
                break;
            case '04':
                $valeur_taux = 2300;
                break;
            case '05':
                $valeur_taux = 2300;
                break;
            case '06':
                $valeur_taux = 2500;
                break;
            case '07':
                $valeur_taux = 2500;
                break;
            default:
                # code...
                break;
        }

        $abn = Abonnement::find($abonnement);
        $societe = $abn->name;
        $demandes = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', $month)
            ->where('patient_abonnes.abonnement_id', $abonnement)
            ->whereYear('demande_consultations.created_at', $year)
            ->orderBy('demande_consultations.numero', 'ASC')
            ->get();
        $speciales = DemandeSpeciale::whereMonth('date_venue', $month)
            ->where('type', $abn->name)
            ->orderBy('numero', 'ASC')
            ->whereYear('created_at', $year)
            ->get();

        //dd($speciales);
        $datePrinter = date('d-m-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-releve-month', compact(['entete', 'speciales', 'valeur_taux', 'societe', 'demandes', 'datePrinter', 'mtLetter']));
        return $pdf->stream();
    }
    //RELEVE PREIODIQUE
    public function printRevlePeriode($dateFrom, $dateTo, $abonnement, $mtLetter, $entete)
    {
        $rate = Rate::where('is_active', true)->first();

        $valeur_taux = $rate->reate;
        $abn = Abonnement::find($abonnement);
        $societe = $abn->name;
        $demandes = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->where('patient_abonnes.abonnement_id', $abonnement)
            ->whereBetween('demande_consultations.created_at', [$dateFrom, $dateTo])
            ->orderBy('demande_consultations.numero', 'ASC')
            ->whereYear('demande_consultations.created_at', date('Y'))
            ->get();
        $speciales = DemandeSpeciale::whereMonth('date_venue', date('m-d-Y'))
            ->where('type', $abn->name)
            ->orderBy('numero', 'ASC')
            ->whereYear('created_at', date('Y'))
            ->get();
        $datePrinter = date('d-m-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-releve-periode', compact(['entete', 'speciales', 'valeur_taux', 'societe', 'demandes', 'datePrinter', 'mtLetter']));
        return $pdf->stream();
    }

    public function printRecetteSpeciales($month, $type, $year)
    {
        $rate = Rate::where('is_active', true)->first();
        $valeur_taux = $rate->rate;
        $speciales = DemandeSpeciale::whereDate('created_at', date('Y-m-d'))
            ->where('type', $type)
            ->orderBy('numero', 'ASC')
            ->whereYear('created_at', $year)
            ->get();
        $datePrinter = date('d-m-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.print-situation-speciales', compact(['speciales', 'valeur_taux', 'datePrinter']));
        return $pdf->stream();
    }

    //PHARMACIE
    public function printSitutaionAmbulant($d)
    {
        $situations = FactureAbulant::whereDate('created_at', $d)->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.pharma-prints.print-rapport-ambulants', compact(['situations', 'd']));
        return $pdf->stream();
    }
    public function printSitutaionAbonnees($d, $a)
    {

        $abonnement = Abonnement::find($a);
        $name_abn = $abonnement->name;
        $demande = FactPharmaAbn::select(
            'demande_consultations.*',
            'fact_pharma_abns.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.Prenom'
        )
            ->join('demande_consultations', 'fact_pharma_abns.demande_consultation_id', '=', 'demande_consultations.id')
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', $d)
            ->where('patient_abonnes.abonnement_id', $a)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'pages.pharma-prints.print-rappport-abonnes',
            compact(['demande', 'd', 'name_abn'])
        );
        return $pdf->stream();
    }
    public function printSitutaionHospitalise($d)
    {
        $demande = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_prives.Nom',
            'patient_prives.Postnom',
            'patient_prives.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_prives', 'patient_prives.fiche_id', '=', 'fiches.id')
            ->where('demande_consultations.is_inteneted', true)
            ->whereDate('demande_consultations.created_at', $d)
            ->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.pharma-prints.print-rapport-hospitalises', compact(['demande', 'd']));
        return $pdf->stream();
    }

    public function printSitutaionBac($d)
    {
        $situations = FactureBacPharma::whereDate('created_at', $d)->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.pharma-prints.print-rapport-bac-compoent', compact(['situations', 'd']));
        return $pdf->stream();
    }
    public function printReceiptAmbulant($id)
    {
        $facture = FactureAbulant::find($id);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.pharma-prints.print-receipt-ambulant', compact(['facture']));
        return $pdf->stream();
    }
    public function printSortie($sortie)
    {
        $sortie = SortieService::find($sortie);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.pharma-prints.print-sortie-service', compact(['sortie']));
        return $pdf->stream();
    }
    public function printReceiptHospitaliser($id)
    {
        $facture = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_prives.Nom',
            'patient_prives.Postnom',
            'patient_prives.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_prives', 'patient_prives.fiche_id', '=', 'fiches.id')
            ->where('demande_consultations.id', $id)
            ->first();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.pharma-prints.print-receipt-hospitalises', compact(['facture']));
        return $pdf->stream();
    }

    public function getListProductExceptPrice()
    {
        $products = Product::orderBy('name', 'ASC')->where('is_depreciated', false)->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.product-except-price', compact(['products']));
        return $pdf->stream();
    }

    public function getListProductWithPrice()
    {
        $products = Product::orderBy('name', 'ASC')
            ->where('is_depreciated', false)->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.product-with-price', compact(['products']));
        return $pdf->stream();
    }

    public function getListProductInventaire()
    {
        $products = Product::orderBy('name', 'ASC')->where('is_depreciated', false)->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.product-inventaire', compact(['products']));
        return $pdf->stream();
    }

    public function getListProductStockFin()
    {
        $products = Product::orderBy('name', 'ASC')->where('is_depreciated', false)->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.stock.prints.print-situation-phamra-stock', compact(['products']));
        return $pdf->stream();
    }


    //RAPPORT MENSUEL

    public function printRapporMenstSortiPharma($s, $moi)
    {
        $service = Service::find($s);
        $name_service = $service->name;
        $rapports = SortieService::orderBy('created_at', 'ASC',)
            ->whereMonth('created_at', $moi)
            ->where('service_id', $s)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'pages.prints.rapport-mesuel.rapport-mes-sortie-pharma',
            compact(['rapports', 'name_service'])
        )
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
        return $pdf->stream();
    }

    public function printGrile()
    {
        $consultations = Consultation::where('is_changed', false)->get();
        $labos = ExamenLabo::where('is_changed', false)->get();
        $radios = ExamenRx::where('is_changed', false)->get();
        $echos = Echographie::where('is_changed', false)->get();
        $actes = ActeMedical::where('is_changed', false)->get();
        $autres = Autre::where('is_changed', false)->get();
        $sejours = Sejour::where('is_changed', false)->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'livewire.tarification.print-grille-tarif',
            compact([
                'consultations',
                'labos',
                'radios',
                'echos',
                'actes',
                'actes',
                'autres',
                'sejours'
            ])
        );
        return $pdf->stream();
    }


    public function printGrilePrive()
    {
        $consultations = Consultation::where('is_changed', false)->get();
        $labos = ExamenLabo::where('is_changed', false)->get();
        $radios = ExamenRx::where('is_changed', false)->get();
        $echos = Echographie::where('is_changed', false)->get();
        $actes = ActeMedical::where('is_changed', false)->get();
        $autres = Autre::where('is_changed', false)->get();
        $sejours = Sejour::where('is_changed', false)->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'livewire.tarification.print-grille-tarif-prive',
            compact([
                'consultations',
                'labos',
                'radios',
                'echos',
                'actes',
                'actes',
                'autres',
                'sejours'
            ])
        );
        return $pdf->stream();
    }


    public function printGrileAbonne()
    {
        $consultations = Consultation::where('is_changed', false)->get();
        $labos = ExamenLabo::where('is_changed', false)->get();
        $radios = ExamenRx::where('is_changed', false)->get();
        $echos = Echographie::where('is_changed', false)->get();
        $actes = ActeMedical::where('is_changed', false)->get();
        $autres = Autre::where('is_changed', false)->get();
        $sejours = Sejour::where('is_changed', false)->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'livewire.tarification.print-grille-tarif-abonne',
            compact([
                'consultations',
                'labos',
                'radios',
                'echos',
                'actes',
                'actes',
                'autres',
                'sejours'
            ])
        );
        return $pdf->stream();
    }

    public function getFinPharmaAbonnes($mois)
    {
        $abonnements = Abonnement::where('name', '!=', 'Privé')->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.rapport-mesuel.print-rapport-fin-abonnes-mens', compact([
            'abonnements',
            'mois'
        ]))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
        return $pdf->stream();
    }

    public function printConsommation($currentDate, $currentMonth)
    {
        $myDate = Carbon::DECEMBER;
        $products = Product::whereMonth('is_depreciated', false)
            ->orderBy('name', 'ASC')
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'pages.prints.rapport-mesuel.print-commation-prod-mensuelle',
            compact([
                'products',
                'currentDate', 'currentMonth'
            ])
        );
        return $pdf->stream();
    }

    public function getSituationFinMontPharma($mois)
    {
        $prive = $this->getPrive($mois);
        $abonne = $this->getAbonnees($mois);
        $ambulant = $this->getAmbulant($mois);
        $special = $this->getSpecial($mois);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'pages.prints.rapport-mesuel.print-situation-fin-maonth-pharma',
            compact([
                'prive', 'abonne', 'ambulant', 'special', 'mois'
            ])
        )
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');;
        return $pdf->stream();
    }

    public function getSituationVentesMonthPharma($mois)
    {
        $ventes = FactureAbulant::orderBy('created_at', 'ASC')
            ->whereMonth('created_at', $mois)
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'pages.prints.rapport-mesuel.print-ventes-month',
            compact([
                'ventes', 'mois'
            ])
        )
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');
        return $pdf->stream();
    }
    public function printVentesAbonneMonth($mois, $abonnement)
    {
        $rate = Rate::where('is_active', true)->first();
        $valeur_taux = $rate->rate;
        $abn = Abonnement::find($abonnement);
        $societe = $abn->name;
        $demandes = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', $mois)
            ->where('patient_abonnes.abonnement_id', $abonnement)
            ->orderBy('demande_consultations.numero', 'ASC')
            ->get();
        $datePrinter = date('d-m-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'pages.prints.rapport-mesuel.print-ventes-abonnes-month',
            compact(['societe', 'demandes', 'mois'])
        )->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');;
        return $pdf->stream();
    }
    public function printSituationPrivésPharma($mois)
    {
        $factures = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_prives.Nom',
            'patient_prives.Postnom',
            'patient_prives.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_prives', 'patient_prives.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', $mois)
            ->orderBy('demande_consultations.created_at', 'ASC')
            ->get();
        $specials = DemandeSpeciale::whereMonth('created_at', $mois)
            ->where('type', 'Privé')
            ->orderBy('numero', 'ASC')
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'pages.prints.rapport-mesuel.print-rapp-pharma-hospitalises',
            compact([
                'factures', 'specials', 'mois'
            ])
        )
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('rapprt_fact-pharma-hosp.pdf');
        return $pdf->stream();
    }

    public function getRapportPatientPriveMonth($mois)
    {
        $demandes = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_prives.Nom',
            'patient_prives.Postnom',
            'patient_prives.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_prives', 'patient_prives.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', $mois)
            ->orderBy('demande_consultations.created_at', 'ASC')
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.demandes.print-rapport-patients-prives', compact(['demandes', 'mois']));
        return $pdf->stream();
    }

    public function getRapportPatientAbonnesMonth($mois, $societe)
    {
        $society = Abonnement::find($societe);
        $societe_name = $society->name;
        $demandes = DemandeConsultation::select(
            'demande_consultations.*',
            'patient_abonnes.Nom',
            'patient_abonnes.Postnom',
            'patient_abonnes.DateNaissance',
            'patient_abonnes.Prenom'
        )
            ->join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->whereMonth('demande_consultations.created_at', $mois)
            ->where('patient_abonnes.abonnement_id', $societe)
            ->orderBy('demande_consultations.numero', 'ASC')
            ->where('demande_consultations.source', 'Golf')
            ->whereYear('demande_consultations.created_at', '2022')
            ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pages.prints.demandes.print-rapport-patients-abonnes', compact(['demandes', 'mois', 'societe_name']));
        return $pdf->stream();
    }


    public function getPrive($mois)
    {
        $total1 = 0;
        $total2 = 0;
        $demandes = DemandeConsultation::join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_prives', 'patient_prives.fiche_id', '=', 'fiches.id')
            ->where('fiches.type', 'Privé')
            ->whereMonth('demande_consultations.created_at', $mois)
            ->get();
        //dd($demandes);
        foreach ($demandes as $demande) {
            if ($demande->products->isEmpty()) {
            } else {

                foreach ($demande->products as $product) {
                    $total1 += $product->pivot->qty * $product->price;
                }
            }

            if ($demande->medications->isEmpty()) {
            } else {
                foreach ($demande->medications as $medication) {
                    $total2 += $medication->product->price * $medication->qty;
                }
            }
        }

        return $total1 + $total2;
    }

    public function getAbonnees($mois)
    {
        $total1 = 0;
        $total2 = 0;
        $demandes = DemandeConsultation::join('fiches', 'demande_consultations.fiche_id', '=', 'fiches.id')
            ->join('patient_abonnes', 'patient_abonnes.fiche_id', '=', 'fiches.id')
            ->where('fiches.type', 'Abonné')
            ->whereMonth('demande_consultations.created_at', $mois)
            ->get();
        //dd($demandes);
        foreach ($demandes as $demande) {
            if ($demande->products->isEmpty()) {
            } else {

                foreach ($demande->products as $product) {
                    $total1 += $product->pivot->qty * $product->price;
                }
            }

            if ($demande->medications->isEmpty()) {
            } else {
                foreach ($demande->medications as $medication) {
                    $total2 += $medication->product->price * $medication->qty;
                }
            }
        }

        return $total1 + $total2;
    }

    public function getAmbulant($mois)
    {
        $total = 0;
        $facture = FactureAbulant::whereMonth('created_at', $mois)->get();
        foreach ($facture as $facture) {
            if ($facture->products->isEmpty()) {
            } else {
                foreach ($facture->products as $product) {
                    $total += $product->pivot->qty * $product->price;
                }
            }
        }
        return $total;
    }

    public function getSpecial($mois)
    {
        $total = 0;
        $facture = DemandeSpeciale::whereMonth('date_venue', $mois)->get();
        foreach ($facture as $facture) {
            if ($facture->products->isEmpty()) {
            } else {
                foreach ($facture->products as $product) {
                    $total += $product->pivot->qty * $product->price;
                }
            }
        }
        return $total;
    }
}
