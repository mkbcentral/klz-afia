<?php

namespace App\Http\Livewire\Labo;

use App\Models\Abonnement;
use App\Models\ResultatLabo;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ResultatLaboComponent extends Component
{
    use WithFileUploads;
    public $name,$type,$resultat_file;
    public $types;
    public $resultat,$resultat_to_delete;
    public $dateSearch,$typeSearch,$currentDate;
    protected $listeners=['resultatLaboDeleteListener'=>'destroy'];


    public function store(){
        $this->validate([
            'name'=>'required',
            'type'=>'required',
            'resultat_file' => 'required|mimes:pdf|max:1024', // 1MB Max
        ]);
        try {
            $pdf_name=time().'_'.$this->resultat_file->getClientOriginalName();
            $pdf_path = $this->resultat_file->storeAs('pdfs', $pdf_name,'public');
            $reusltat=ResultatLabo::create([
                'name'=>$this->name,
                'type'=>$this->type,
                'location'=>$pdf_path,
                'user_id'=>Auth::user()->id
            ]);
            $this->dispatchBrowserEvent('data-added',['message'=>'Resultat du patient '.$this->name.' bien publié']);
        } catch(QueryException $ex){
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function show($id){
        $this->resultat=ResultatLabo::find($id);
        $this->name= $this->resultat->name;
        $this->type= $this->resultat->type;
    }

    public function showDeleteDialog($id){
        $this->resultat_to_delete=ResultatLabo::find($id);
        $this->dispatchBrowserEvent('show-delete-confirmation-resultat');
    }

    public function destroy(){
        $this->resultat_to_delete->delete();
        $this->dispatchBrowserEvent('data-resulta-deleted',['message'=>"Resultat bien rétiré !"]);
    }

    public function update(){
        if ($this->resultat_file ==null) {
            $this->validate([
                'name'=>'required',
                'type'=>'required',
            ]);
            try {
                $this->resultat->name=$this->name;
                $this->resultat->type=$this->type;
                $this->resultat->update();
                $this->dispatchBrowserEvent('data-updated',['message'=>'Resultat du patient '.$this->name.' bien mis à jour']);
            } catch(QueryException $ex){
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
            }
        }
        else{
            $this->validate([
                'name'=>'required',
                'type'=>'required',
                'resultat_file' => 'required|mimes:pdf|max:1024', // 1MB Max
            ]);
            try {
                $pdf_name=time().'_'.$this->resultat_file->getClientOriginalName();
                $pdf_path = $this->resultat_file->storeAs('pdfs', $pdf_name,'public');
                $this->resultat->name=$this->name;
                $this->resultat->type=$this->type;
                $this->resultat->location=$pdf_path;
                $this->resultat->update();
                $this->dispatchBrowserEvent('data-updated',['message'=>'Resultat du patient '.$this->name.' bien mis à jour']);
            } catch(QueryException $ex){
            } catch(QueryException $ex){
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
            }
        }
    }

    public function updatedtypeSearch(){

    }

    public function mount(){
        $this->types=Abonnement::all();
        $this->currentDate=Carbon::now();

    }
    public function render()
    {
        return view('livewire.labo.resultat-labo-component',
            [
                'resultats'=>ResultatLabo::where('type','LIKE','%'.$this->typeSearch.'%')
                    ->whereDate('created_at',$this->currentDate)
                    ->get()
            ]
        );
    }
}
