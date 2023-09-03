<?php

namespace App\Http\Livewire\Tarification\Sejour;

use App\Models\Sejour;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class TarificatiionSejour extends Component
{
    use WithPagination;
    public $name,$price_prive,$price_abonne;
    public $sejour;
    public function save(){
        $this->validateData();
        try {
            $sejour=new Sejour();
            $sejour->name=$this->name;
            $sejour->price_prive=$this->price_prive;
            $sejour->price_abonne=$this->price_abonne;
            $sejour->save();

            $this->dispatchBrowserEvent('data-added',['message'=>"Infos  ajoutés ! !"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->sejour=Sejour::find($id);
        $this->name=$this->sejour->name;
        $this->price_prive=$this->sejour->price_prive;
        $this->price_abonne=$this->sejour->price_abonne;
    }

    public function update(){
        $this->validateData();
        try {
            $this->sejour->name=$this->name;
            $this->sejour->price_prive=$this->price_prive;
            $this->sejour->price_abonne=$this->price_abonne;
            $this->sejour->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Info modifié"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function activate($id){
        $sejour=Sejour::find($id);
        $sejour->is_changed=false;
        $sejour->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Info bien retiré"]);
    }

    public function unActivate($id){
        $sejour=Sejour::find($id);
        $sejour->is_changed=true;
        $sejour->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Info bien retiré"]);
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
        return view('livewire.tarification.sejour.tarificatiion-sejour',[
            'sejours'=>Sejour::where('is_changed',false)->get()
        ]);
    }
}
