<?php

namespace App\Http\Livewire\Rapport;

use App\Models\DemandeConsultation;
use App\Models\Product;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;

class ConsommationPharmaComponent extends Component
{
    public $myDate,$currentDate,$currentMonth,$keySearch;

    public function getByDate(){
        $this->currentDate=$this->myDate;
        $this->currentMonth=(new DateTime($this->myDate))->format('m');
    }
    public function mount(){
       $this->currentDate=date('Y-m-d');
       $this->currentMonth=date('m');
    }
    public function render()
    {
        return view('livewire.rapport.consommation-pharma-component',[
            'products'=>Product::whereMonth('is_depreciated',false)
                        ->where('name','Like','%'.$this->keySearch.'%')
                        ->orderBy('name','ASC')
                        ->get()
        ]);
    }
}
