<?php

namespace App\Http\Livewire\Tarification\Labo;

use App\Models\ExamenLabo;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;
use Mockery\CountValidator\Exact;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Expr\FuncCall;

class TarificatiionLabo extends Component
{
    use WithPagination;

    public $name,$abreviation="Aucune",$price_prive,$price_abonne;
    public $examen;
    public $keySearch='';


    public function save(){
        $this->validateData();
        try {
            $examenLabo=new ExamenLabo();
            $examenLabo->name=$this->name;
            $examenLabo->abreviation=$this->abreviation;
            $examenLabo->price_prive=$this->price_prive;
            $examenLabo->price_abonne=$this->price_abonne;
            $examenLabo->save();

            $this->dispatchBrowserEvent('data-added',['message'=>"Examentlabo bien ajouté ! !"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function edit($id){
        $this->examen=ExamenLabo::find($id);
        $this->name=$this->examen->name;
        $this->abreviation=$this->examen->abreviation;
        $this->price_prive=$this->examen->price_prive;
        $this->price_abonne=$this->examen->price_abonne;
    }

    public function update(){
        $this->validateData();
        try {
            $this->examen->name=$this->name;
            $this->examen->abreviation=$this->abreviation;
            $this->examen->price_prive=$this->price_prive;
            $this->examen->price_abonne=$this->price_abonne;
            $this->examen->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Exemen bien modifié"]);
        } catch (QueryException $ex) {
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function activate($id){
        $examen=ExamenLabo::find($id);
        $examen->is_changed=false;
        $examen->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Exemen bien retiré"]);
    }

    public function unActivate($id){
        $examen=ExamenLabo::find($id);
        $examen->is_changed=true;
        $examen->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>"Exemen bien retiré"]);
    }

    public function validateData(){
        $this->validate([
            'name'=>'required',
            'abreviation'=>'required',
            'price_prive'=>'required|numeric',
            'price_abonne'=>'required|numeric',

        ]);
    }


    public function render()
    {
        return view('livewire.tarification.labo.tarificatiion-labo',[
            'labos'=>ExamenLabo::where('is_changed',false)
                        ->orderBy('name','ASC')
                        ->where('name','like','%'.$this->keySearch.'%')
                        ->get()
        ]);
    }
}
