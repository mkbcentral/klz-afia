<?php

use App\Http\Controllers\DataPharmaController;
use App\Http\Controllers\ExportationController;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Pages\PrinterController;
use App\Http\Livewire\Admin\AdminComponent;
use App\Http\Livewire\Admin\Users\ProfilComponent;
use App\Http\Livewire\Consommation\Product\ConsommationWeekProductComponent;
use App\Http\Livewire\DataPharmaPage;
use App\Http\Livewire\DataPharmaPeriode;
use App\Http\Livewire\Demandes\HistoriqueDemandesComponent;
use App\Http\Livewire\Factures\Facturation\CreateFactureAbonnesComponent;
use App\Http\Livewire\Factures\Facturation\CreateFactureComponent;
use App\Http\Livewire\Factures\Facturation\FacturationComponent;
use App\Http\Livewire\Factures\Historique\HistoriqueComponent;
use App\Http\Livewire\Finance\FinanceComponent;
use App\Http\Livewire\Hospitalisation\HospitalisationAbonnesDetailsComponent;
use App\Http\Livewire\Hospitalisation\HospitalisationComponent;
use App\Http\Livewire\Hospitalisation\HospitalisationDetailsComponent;
use App\Http\Livewire\Labo\LaboComponent;
use App\Http\Livewire\NursingComponent;
use App\Http\Livewire\Patients\PatientCompnent;
use App\Http\Livewire\Pharmacie\Facturatio\FacturationPharmacieComponent;
use App\Http\Livewire\Pharmacie\Facturation\Abonnes\OrderFactureAbonneComponent;
use App\Http\Livewire\Pharmacie\PharmacieComponent;
use App\Http\Livewire\Pharmacie\Rapport\RapportComponent;
use App\Http\Livewire\Pharmacie\TrashComponent;
use App\Http\Livewire\Rapport\RapportMensuelComponent;
use App\Http\Livewire\Rdvs\RdvsComponent;
use App\Http\Livewire\Speciales\CreateFacturesSpeciales;
use App\Http\Livewire\Speciales\DemandesSpecialesComponent;
use App\Http\Livewire\Stock\StockComponent;
use App\Http\Livewire\Tarification\ListeTarifComponent;
use App\Http\Livewire\Tarification\TarificationComponent;
use App\Models\Nursing;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('home')->middleware(['auth','is.admin']);;


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth','is.admin']);


Route::middleware(['auth','is.admin'])->group(function () {
    Route::get('utilisateurs',AdminComponent::class)->name('admin');
    Route::get('profils',ProfilComponent::class)->name('user.profil');
    Route::get('laboratoire',LaboComponent::class)->name('labo');
    Route::get('gestion-des-patients',PatientCompnent::class)->name('patients');
    Route::get('historique-demandes',HistoriqueDemandesComponent::class)->name('demandes');
    Route::get('facturation',FacturationComponent::class)->name('facturation');
    Route::get('hisitorique-facturation',HistoriqueComponent::class)->name('historique');
    Route::get('demandes-speciales',DemandesSpecialesComponent::class)->name('speciales');
    Route::get('finance',FinanceComponent::class)->name('finance');
    Route::get('pharmacie',PharmacieComponent::class)->name('pharmacie');
    Route::get('facturation-pharmacie',FacturationPharmacieComponent::class)->name('pharmacie.facturation');
    Route::get('rapport-pharmacie',RapportComponent::class)->name('pharmacie.rapport');
    Route::get('ma-corbeil',TrashComponent::class)->name('pharmacie.trash');
    Route::get('mes-rdvs',RdvsComponent::class)->name('rdvs');
    Route::get('Tarification',TarificationComponent::class)->name('tarification');
    Route::get('liste-tarif',ListeTarifComponent::class)->name('tarification.liste');

    Route::get('data-pharma',DataPharmaPage::class)->name('data.pharma');
    Route::get('data-pharma-per',DataPharmaPeriode::class)->name('data.pharma.period');


    Route::get('create-facture-prive/{facture}',CreateFactureComponent::class)->name('create.facture');
    Route::get('create-facture-abonnes/{facture}',CreateFactureAbonnesComponent::class)->name('create.facture.abonne');
    Route::get('create-facture-speciale/{facture}',CreateFacturesSpeciales::class)->name('create.facture.speciale');
    Route::get('order-pharma-abonne/{facture}',OrderFactureAbonneComponent::class)->name('create.order.facture');
    Route::get('rapport-mensuel/',RapportMensuelComponent::class)->name('rapport.mensuel');

    Route::get('gestion-stock/',StockComponent::class)->name('stock.index');

    //CONSOMMATION WEEK
    Route::get('/consommation-week-product/{week}',ConsommationWeekProductComponent::class)->name('consommation.week');

    Route::get('firle-attente',NursingComponent::class)->name('file.attente');
    Route::get('hospitalisation',HospitalisationComponent::class)->name('hospitalisation');
    Route::get('details-hospitalisation/{facture}',HospitalisationDetailsComponent::class)->name('hospitalisation.details');
    Route::get('details-hospitalisation-abonnes/{facture}',HospitalisationAbonnesDetailsComponent::class)->name('hospitalisation.details.abpnnes');
});



//PRINTER ROUTES
Route::get('print-fact-prive/{facture}',[PrinterController::class,'printFactPrive'])->name('print.fact.prives');
Route::get('print-fact-abonnes/{facture}',[PrinterController::class,'printFactAbonnes'])->name('print.fact.abones');
Route::get('print-fact-specaile/{facture}',[PrinterController::class,'printFactSpeciale'])->name('print.fact.speciale');

Route::get('impression/{ente}/{month}/{abonnement}/{mtLetter}/{currentYear}',[PrinterController::class,'printRevleMonth'])->name('print.revele.month');
Route::get('impression-all/{month}/{abonnement}/{currentYear}',[PrinterController::class,'printAllFactAbonnes'])->name('print.fact.abn.all');

Route::get('impression-periode/{dateFrom}/{dateTo}/{abonnement}/{mtLetter}/{entete}',[PrinterController::class,'printRevlePeriode'])->name('print.revele.periode');
Route::get('impression-facts-periode/{dateFrom}/{dateTo}/{abonnement}',[PrinterController::class,'printFactAllPeriode'])->name('print.fact.abn.all.periode');
Route::get('impression-receettes/{month}/{type}/{year}',[PrinterController::class,'printRecetteSpeciales'])->name('print.recettes.speciale');

Route::get('impression-recption-1/{mois}',[PrinterController::class,'getRapportPatientPriveMonth'])->name('print.reception.month');
Route::get('impression-recption-2/{mois}/{societe}',[PrinterController::class,'getRapportPatientAbonnesMonth'])->name('print.reception.month.abonnes');
//PRINT PHARMACIE
Route::get('print-rapport-ambulant/{date}',[PrinterController::class,'printSitutaionAmbulant'])->name('sitution.ambulatnt.print');
Route::get('/situation-abonnes/{date}/{abonnement}',[PrinterController::class,'printSitutaionAbonnees'])->name('sitution.abonnes');
Route::get('situation-hospitalise/{date}',[PrinterController::class,'printSitutaionHospitalise'])->name('sitution.hopitalise');
Route::get('situation-bac-print/{d}',[PrinterController::class,'printSitutaionBac'])->name('sitution.bac.print');
Route::get('print-receipt-ambulant/{id}',[PrinterController::class,'printReceiptAmbulant'])->name('print.receipt.ambulant');
Route::get('print-receipt-hospitalise/{facture}',[PrinterController::class,'printReceiptHospitaliser'])->name('print.receipt.hospitalise');
Route::get('print-list-product-1',[PrinterController::class,'getListProductExceptPrice'])->name('product.except.price');
Route::get('print-list-product-2',[PrinterController::class,'getListProductWithPrice'])->name('product.with.price');
Route::get('print-list-product-3',[PrinterController::class,'getListProductInventaire'])->name('product.inventaire');
Route::get('print-pharma-stock-products',[PrinterController::class,'getListProductStockFin'])->name('product.pharma.stock.fin');
Route::get('sortie/{sortie}',[PrinterController::class,'printSortie'])->name('product.sortie.service');

//RAPPORT MENSUEL
Route::get('rapport-sortie-pharma/{service}/{moi}',[PrinterController::class,'printRapporMenstSortiPharma'])->name('print.rapp.mens.pharmacie.sortie');
Route::get('impressiion-grille',[PrinterController::class,'printGrile'])->name('grille.ptint.all');
Route::get('impressiion-grille-prive',[PrinterController::class,'printGrilePrive'])->name('grille.ptint.prive');
Route::get('impressiion-grille-abonne',[PrinterController::class,'printGrileAbonne'])->name('grille.ptint.abonne');
Route::get('/consommation-prods/{d1}/{d2}',[PrinterController::class,'printConsommation'])->name('commations.prods');
Route::get('/facture-pharma-hosp/{mois}',[PrinterController::class,'printSituationPrivésPharma'])->name('pharma.prives.hosp');


Route::get('/rapport-fin-pharma/{mois}',[PrinterController::class,'getFinPharmaAbonnes'])->name('parrot.fin.abones.abonnes');
Route::get('/fin-pharm-month/{d}',[PrinterController::class,'getSituationFinMontPharma'])->name('fin.pharma.month');
Route::get('/ventes-pharm-month/{d}',[PrinterController::class,'getSituationVentesMonthPharma'])->name('ventes.pharma.month');
Route::get('/ventes-pharm-month/{m}/{abon}',[PrinterController::class,'printVentesAbonneMonth'])->name('ventes.abonnes.pharma.month');


Route::get('data/{month}/{year}',[DataPharmaController::class,'getProds'])->name('print.data.pharma');


Route::get('/export',[ExportationController::class,'exprortProducts']);
