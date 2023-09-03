<?php

namespace App\Http\Livewire\Tarification\Actes;

use App\Models\ActeMedical;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class TarificatiionActes extends Component
{
    use WithPagination;
    public $name,$price_prive,$price_abonne;
    public $acte;
    public function save(){
        $this->validateData();
        try {
            $acte=new ActeMedical();
            $acte->name=$this->name;
            $acte->price_prive=$this->price_prive;
            $acte->price_abonne=$this->price_abonne;
            $acte->save();

            $this->dispatchBrowserEvent('data-added',['message'=>"Infos  ajoutés ! !"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->acte=ActeMedical::find($id);
        $this->name=$this->acte->name;
        $this->price_prive=$this->acte->price_prive;
        $this->price_abonne=$this->acte->price_abonne;
    }

    public function update(){
        $this->validateData();
        try {
            $this->acte->name=$this->name;
            $this->acte->price_prive=$this->price_prive;
            $this->acte->price_abonne=$this->price_abonne;
            $this->acte->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Info modifié"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function activate($id){
        $cons=ActeMedical::find($id);
        $cons->is_changed=false;
        $cons->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Exemen bien retiré"]);
    }

    public function unActivate($id){
        $cons=ActeMedical::find($id);
        $cons->is_changed=true;
        $cons->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Exemen bien retiré"]);
    }

    public function validateData(){
        $this->validate([
            'name'=>'required',
            'price_prive'=>'required|numeric',
            'price_abonne'=>'required|numeric',

        ]);
    }

    public function render()
    {
        return view('livewire.tarification.actes.tarificatiion-actes',[
            'actes'=>ActeMedical::where('is_changed',false)->get()
        ]);
    }
}
