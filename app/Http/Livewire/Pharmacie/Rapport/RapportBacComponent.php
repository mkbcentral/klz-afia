<?php

namespace App\Http\Livewire\Pharmacie\Rapport;

use App\Models\FactureBacPharma;
use Carbon\Carbon;
use Livewire\Component;

class RapportBacComponent extends Component
{
    public $data;
    public $searchDate,$currentDate;

    public function getByDate(){
       $this->currentDate=$this->searchDate;
    }
    public function mount(){
        $this->searchDate=Carbon::now();
        $this->currentDate=date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.pharmacie.rapport.rapport-bac-component',[
            'rapports'=>FactureBacPharma::whereDate('created_at',$this->currentDate)->get()
        ]);
    }
}
