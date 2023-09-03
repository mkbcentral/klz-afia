<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user=auth()->user();
        $ucrrentRouteName=Route::currentRouteName();
        $roleName=$user->role->name;
        //dd($roleName);
        if (in_array($ucrrentRouteName,$this->userAccessRole()[$roleName])) {
            return $next($request);
        } else {
            abort(403);
        }

    }

    Public function userAccessRole(){
        return [
            'Super-Admin'=>[
                'dashboard',
                'admin',
                'user.profil',
                'labo',
                'patients',
                'demandes',
                'facturation',
                'historique',
                'speciales',
                'finance',
                'pharmacie',
                'pharmacie.facturation',
                'pharmacie.rapport',
                'create.facture',
                'create.facture.abonne',
                'create.facture.speciale',
                'create.order.facture',
                'pharmacie.trash',
                'dashboard',
                'rapport.mensuel',
                'rdvs',
                'tarification',
                'tarification.liste',
                'home',
                'stock.index',
                'consommation.week',
                'file.attente',
                'data.pharma',
                'data.pharma.period'
            ],
            'Admin'=>[
                'home',
                'user.profil',
                'labo',
                'patients',
                'demandes',
                'facturation',
                'historique',
                'speciales',
                'finance',
                'pharmacie',
                'pharmacie.facturation',
                'pharmacie.rapport',
                'create.facture',
                'create.facture.abonne',
                'create.facture.speciale',
                'create.order.facture',
                'pharmacie.trash',
                'dashboard',
                'rapport.mensuel',
                'rdvs',
                'tarification',
                'tarification.liste',
                'home',
                'stock.index',
                'consommation.week',
                'file.attente',
                'data.pharma',
                'data.pharma.period'
            ],
            'Medecin'=>[
                'file.attente',
                'create.facture',
                'create.facture.abonne',
                'create.facture.speciale',
                'hospitalisation',
                'hospitalisation.details',
                'hospitalisation.details.abpnnes',
                'demandes',
                'home',
            ],
            'Infirmier'=>[
                'file.attente',
                'hospitalisation',
                'hospitalisation.details',
                'hospitalisation.details.abpnnes',
                'demandes',
                'dashboard',
            ],
            'Pharma'=>[
                'pharmacie',
                'pharmacie.facturation',
                'pharmacie.rapport',
                'user.profil',
                'historique',
                'demandes',
                'create.facture',
                'create.facture.abonne',
                'dashboard',
                'create.order.facture',
                'dashboard',
                'rapport.mensuel',
            ],
            'Receptioniste'=>[
                'patients',
                'demandes',
                'user.profil',
                'dashboard',
                'home'
            ],
            'Nursing'=>[
                'demandes',
                'user.profil',
                'patients',
                'create.facture',
                'create.facture.abonne',
                'create.facture.speciale',
                'dashboard',
                'speciales',
                'home',
                'pharmacie'
            ],
            'Labo'=>[
                'file.attente',
                'user.profil',
                'demandes',
                'dashboard'

            ],
            'Medecin chef'=>[
                'labo',
                'historique',
                'user.profil',
                'create.facture',
                'create.facture.abonne',
                'dashboard',
                'home'
            ]
        ];
    }

}
