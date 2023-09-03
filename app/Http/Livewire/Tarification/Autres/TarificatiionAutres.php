<?php

namespace App\Http\Livewire\Tarification\Autres;

use App\Models\Autre;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class TarificatiionAutres extends Component
{
    use WithPagination;
    public $name,$price_prive,$price_abonne;
    public $autre;
    public $keySearch='';
    public function save(){
        $this->validateData();
        try {
            $autre=new Autre();
            $autre->name=$this->name;
            $autre->price_prive=$this->price_prive;
            $autre->price_abonne=$this->price_abonne;
            $autre->save();

            $this->dispatchBrowserEvent('data-added',['message'=>"Infos  ajoutés ! !"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->autre=Autre::find($id);
        $this->name=$this->autre->name;
        $this->price_prive=$this->autre->price_prive;
        $this->price_abonne=$this->autre->price_abonne;
    }

    public function update(){
        $this->validateData();
        try {
            $this->autre->name=$this->name;
            $this->autre->price_prive=$this->price_prive;
            $this->autre->price_abonne=$this->price_abonne;
            $this->autre->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Info modifié"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function activate($id){
        $autre=Autre::find($id);
        $autre->is_changed=false;
        $autre->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Info bien retiré"]);
    }

    public function unActivate($id){
        $autre=Autre::find($id);
        $autre->is_changed=true;
        $autre->update();
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
        return view('livewire.tarification.autres.tarificatiion-autres',[
            'autres'=>Autre::where('is_changed',false)
            ->where('name','like','%'.$this->keySearch.'%')
            ->get()
        ]);
    }
}
