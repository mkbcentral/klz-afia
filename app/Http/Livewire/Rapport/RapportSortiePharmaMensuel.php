<?php

namespace App\Http\Livewire\Rapport;

use App\Models\Service;
use App\Models\SortieService;
use Livewire\Component;

class RapportSortiePharmaMensuel extends Component
{
    public $services,$service_id,$mois,$currentDate;
    public function mount(){
        $this->services=Service::all();
        foreach (range(1,12) as $m) {
            $this->mois[]=date('m',mktime(0,0,0,$m,1));
        }
        $this->currentDate=date('m');
        $this->service_id=0;
    }
    public function render()
    {
        return view('livewire.rapport.rapport-sortie-pharma-mensuel',[
            'sorties'=>SortieService::orderBy('created_at','ASC',)
                    ->whereMonth('created_at',$this->currentDate)
                    ->where('service_id',$this->service_id)
                    ->get()
        ]);
    }
}
