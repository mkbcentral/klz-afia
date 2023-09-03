<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AdminComponent extends Component
{
    public function test(){
        $this->dispatchBrowserEvent('data-added',['message'=>'Utilisateur '.'bien ajouté']);
    }
    public function render()
    {
        return view('livewire.admin.admin-component');
    }
}
