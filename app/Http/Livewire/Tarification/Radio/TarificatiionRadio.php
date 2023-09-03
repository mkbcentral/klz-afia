<?php

namespace App\Http\Livewire\Tarification\Radio;

use App\Models\ExamenRx;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;

class TarificatiionRadio extends Component
{
    use WithPagination;
    public $name,$price_prive,$price_abonne;
    public $cons;
    public function save(){
        $this->validateData();
        try {
            $radio=new ExamenRx();
            $radio->name=$this->name;
            $radio->price_prive=$this->price_prive;
            $radio->price_abonne=$this->price_abonne;
            $radio->save();

            $this->dispatchBrowserEvent('data-added',['message'=>"constlabo bien ajouté ! !"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->cons=ExamenRx::find($id);
        $this->name=$this->cons->name;
        $this->price_prive=$this->cons->price_prive;
        $this->price_abonne=$this->cons->price_abonne;
    }

    public function update(){
        $this->validateData();
        try {
            $this->cons->name=$this->name;
            $this->cons->price_prive=$this->price_prive;
            $this->cons->price_abonne=$this->price_abonne;
            $this->cons->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Exemen bien modifié"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function activate($id){
        $cons=ExamenRx::find($id);
        $cons->is_changed=false;
        $cons->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Exemen bien retiré"]);
    }

    public function unActivate($id){
        $cons=ExamenRx::find($id);
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
        return view('livewire.tarification.radio.tarificatiion-radio',[
            'radios'=>ExamenRx::where('is_changed',false)->orderBy('name','ASC')->paginate(500)
        ]);
    }
}
