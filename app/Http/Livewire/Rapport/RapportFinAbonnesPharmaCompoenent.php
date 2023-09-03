<?php

namespace App\Http\Livewire\Rapport;

use App\Models\Abonnement;
use Livewire\Component;

class RapportFinAbonnesPharmaCompoenent extends Component
{
    public $mois,$currentDate;
    public $abonnements;
    public function mount(){
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }

        $this->abonnements=Abonnement::where('name','!=','Privé')->get();
        $this->currentDate=date('m');
    }
    public function render()
    {
        return view('livewire.rapport.rapport-fin-abonnes-pharma-compoenent');
    }
}
