<?php

namespace App\Http\Livewire\Settings;

use App\Models\DemandeConsultation;
use Carbon\Carbon;
use Livewire\Component;

class CounterVilleComponent extends Component
{
    public $counter_ville=0;
    public function mount(){
        $demande=DemandeConsultation::whereDate('created_at',Carbon::now())->where('source','Ville')->get();
        $this->counter_ville=$demande->count();
    }
    public function render()
    {
        return view('livewire.settings.counter-ville-component');
    }
}
