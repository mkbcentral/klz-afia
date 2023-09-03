<?php

namespace App\Http\Livewire\Tarification;

use App\Models\ActeMedical;
use App\Models\Autre;
use App\Models\Consultation;
use App\Models\Echographie;
use App\Models\ExamenLabo;
use App\Models\ExamenRx;
use App\Models\Sejour;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class ListeTarifComponent extends Component
{
    public $consultations,$labos,$radios,$echos,$actes,$autres,$sejours;
    public function mount(){
        $this->consultations=Consultation::where('is_changed',false)->get();
        $this->labos=ExamenLabo::where('is_changed',false)->orderBy('name','ASC')->get();
        $this->radios=ExamenRx::where('is_changed',false)->get();
        $this->echos=Echographie::where('is_changed',false)->get();
        $this->actes=ActeMedical::where('is_changed',false)->get();
        $this->autres=Autre::where('is_changed',false)->get();
        $this->sejours=Sejour::where('is_changed',false)->get();
    }
    public function render()
    {
        return view('livewire.tarification.liste-tarif-component');
    }
}
