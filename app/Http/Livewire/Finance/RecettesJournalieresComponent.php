<?php

namespace App\Http\Livewire\Finance;

use App\Models\Depense;
use App\Models\Recettes;
use Livewire\Component;

class RecettesJournalieresComponent extends Component
{
    public $mt_cdf=0;public $mt_usd=0;public $devise;
    public $recette;
    public $mt_depense=0,$libelle;

    public function store(){
        $this->validate([
            'mt_cdf'=>'required|numeric',
            'mt_usd'=>'required|numeric',
        ]);
        try {
            $recette=Recettes::create([
                'numero'=>'PS.'.date('d').'.'.date('m').'.'.date('y').'.'.rand(100,1000).'.RCT',
                'mt_cdf'=>$this->mt_cdf,
                'mt_usd'=>$this->mt_usd,
            ]);
            $this->dispatchBrowserEvent('data-added',['message'=>"Recette bien bien étabie"]);
          } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
          }

    }

    public function show($id){
        $this->recette=Recettes::find($id);
        $this->mt_cdf=$this->recette->mt_cdf;
        $this->mt_usd=$this->recette->mt_usd;
    }

    public function update(){
        $this->recette->mt_cdf=$this->mt_cdf;
        $this->recette->mt_usd=$this->mt_usd;
        $this->recette->devise=$this->devise;
        try {
           $this->recette->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>"Recette mise à jour"]);
          } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
          }
    }

    public function storeDepense(){
        $this->validate([
            'mt_depense'=>'required|numeric',
            'devise'=>'required',
        ]);

        try {
            $recette=Depense::create([
                'numero'=>'PS.'.date('d').'.'.date('m').'.'.date('y').'.'.rand(100,1000).'.DEP',
                'mt'=>$this->mt_depense,
                'devise'=>$this->devise,
                'libelle'=>$this->libelle,
                'recettes_id'=>$this->recette->id,
            ]);
            $this->dispatchBrowserEvent('data-added',['message'=>"Depense bien bien étabie"]);
          } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
          }
    }
    public function render()
    {
        return view('livewire.finance.recettes-journalieres-component',[
            'recettes'=>Recettes::all()
        ]);
    }
}
