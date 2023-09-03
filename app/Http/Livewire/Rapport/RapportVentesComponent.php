<?php

namespace App\Http\Livewire\Rapport;

use App\Models\FactureAbulant;
use Carbon\Carbon;
use Livewire\Component;

class RapportVentesComponent extends Component
{
    public $mois;
    public $keySearch,$currentDate;

    public function mount(){
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->currentDate=date('m');
    }
    public function render()
    {
        return view('livewire.rapport.rapport-ventes-component',[
            'factures'=>FactureAbulant::orderBy('created_at','DESC')
                ->whereMonth('created_at',$this->currentDate)
                ->get()
        ]);
    }
}
