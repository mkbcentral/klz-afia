<?php

namespace App\Http\Livewire\Pharmacie\Rapport;

use App\Models\FactureAbulant;
use Carbon\Carbon;
use Livewire\Component;

class RapportAmbulantComponent extends Component
{
    public $data;
    public $searchDate,$dateTo,$dateFrom,$currentDate;

    public function getByDate(){
        $this->currentDate=$this->searchDate;
        //dd($this->currentDate);
    }

    public function getDateBetween(){
        $this->data=FactureAbulant::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->get();

    }

    public function mount(){
        $this->currentDate=date('Y-m-d');
    }
    public function render()
    {
        return view('livewire.pharmacie.rapport.rapport-ambulant-component',[
            'rapports'=>FactureAbulant::whereDate('created_at',$this->currentDate)->get()
        ]);
    }
}
