<?php

namespace App\Http\Livewire;

use App\Models\DemandeConsultation;
use App\Models\Product;
use Livewire\Component;

class DataPharmaPage extends Component
{
    public $years=['2021','2022','2023','2024','2025'];
    public $currentYear;
    public $months=[];
    public $currentMonth;


    public function updatedCurrentMonth(){
        //dd($this->currentMonth);
    }
    public function updatedCurrentYear(){
        //dd($this->currentYear);
    }

    public function mount(){
        $this->currentYear=date('Y');
        $this->currentMonth=date('m');
        foreach (range(1,12) as $m) {
            $this->months[]=date('m',mktime(0,0,0,$m,1));
        }
    }
    public function render()
    {
        $pproducts = Product::orderBy('name','ASC')->get();
        return view('livewire.data-pharma-page',['products'=>$pproducts]);
    }
}
