<?php

namespace App\Http\Livewire\Settings;

use App\Models\DemandeConsultation;
use Carbon\Carbon;
use Livewire\Component;

class CounterGolfComponent extends Component
{
    public $counter_golf=0;
    public function mount(){
        $demande=DemandeConsultation::whereDate('created_at',Carbon::now())->where('source','Golf')->get();
        $this->counter_golf=$demande->count();
    }
    public function render()
    {
        return view('livewire.settings.counter-golf-component');
    }
}
