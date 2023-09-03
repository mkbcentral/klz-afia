<?php

namespace App\Http\Livewire\Patients\Forfait;

use App\Models\Famille;
use App\Models\MembreFamille;
use App\Models\SocieteForfait;
use Livewire\Component;
use Livewire\WithPagination;
use PhpParser\Builder\Function_;

class PatientsForfaitComponent extends Component
{
    use WithPagination;

    public $societes,$isSelected=false;
    public $page_number=10,$keySearch='';
    public $socity_name='';

    protected $listeners=['famillyToDelete'=>'distroyFamilly','memberToDelete'=>'distroyMember'];


    public $name_familly;
    public $matricule='DEFAULT';
    public $quota=6;
    public  $societe_to_add;
    public $societe_id;
    public $famille_to_edit;
    public $societe_name_to_edit;

    public $member_familly_name,$member_fmailly_date_naiss,$member_familly_type,$member_familly_id;
    public $familly_to_add_member,$familly_id_to_in_member;
    public $members_family;
    public $member_data,$member_data_id,$member_data_to_edit;

    public $member_name_to_edit;
    public $member_date_naiss_to_edit;
    public $member_type_to_edit;

    public $familly_to_delete_id,$member_to_delete_id;

    public function updatingkeySearch(){
        $this->resetPage();
    }

    public function selectSocieteItem(){
        $this->isSelected=true;
    }

    public function store(){
        $this->validate([
            'name_familly'=>'required',
            'matricule'=>'required',
        ]);
        try {
            Famille::create(
                [
                    'name'=>$this->name_familly,
                    'matricule'=>$this->matricule,
                    'quota'=>$this->quota,
                    'societe_forfait_id'=>$this->societe_id,
                ]
            );
            $this->dispatchBrowserEvent('data-added',['message'=>"Famille bien ajout"]);

        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }
    }

    public function refresh($id){
        $this->members_family=Famille::find($id);
    }

    public function edit($id){

        $famille=Famille::find($id);
        $this->name_familly=$famille->name;
        $this->matricule=$famille->matricule;
        $this->societe_id=$famille->societe_forfait_id;
        $this->famille_to_edit=$famille;
        $this->societe_name_to_edit=$famille->society->name;
    }

    public function update(){
        try {
            $this->famille_to_edit->name=$this->name_familly;
            $this->famille_to_edit->matricule=$this->matricule;
            $this->famille_to_edit->societe_forfait_id=$this->societe_id;

            $this->famille_to_edit->update();

            $this->dispatchBrowserEvent('data-updated',['message'=>"Famille bien mise à jour !"]);

        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }
    }

    public function show($id){
        $famille=Famille::find($id);
        $this->familly_to_add_member=$famille;
        $this->familly_id_to_in_member=$famille->id;
        $this->member_familly_id=$famille->id;
    }

    public function addInFamilly(){
        $this->validate([
            'member_familly_name'=>'required',
            'member_fmailly_date_naiss'=>'required|date',
            'member_familly_type'=>'required'
        ]);
        try {
            MembreFamille::create([
                'noms'=>$this->member_familly_name,
                'date_naissance'=>$this->member_fmailly_date_naiss,
                'type'=>$this->member_familly_type,
                'famille_id'=>$this->member_familly_id,
            ]);
            $this->dispatchBrowserEvent('data-added',['message'=>"Membre bien ajouté dans la famille"]);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }

    }

    public function getMemberFamilly($id){
        $this->members_family=Famille::find($id);

    }

    public function getMemeberData($id){
        $this->member_data_id=$id;
        $member=MembreFamille::find($id);
        $this->member_name_to_edit=$member->noms;
        $this->member_date_naiss_to_edit=$member->date_naissance;
        $this->member_type_to_edit=$member->type;
        $this->member_data_to_edit=$member;
    }

    public function updateMember($id){

        try {
            $this->member_data_to_edit->noms=$this->member_name_to_edit;
            $this->member_data_to_edit->date_naissance=$this->member_date_naiss_to_edit;
            $this->member_data_to_edit->type=$this->member_type_to_edit;
            $this->member_data_to_edit->update();
            $this->member_data_id=null;

            $this->refresh($id);

            $this->dispatchBrowserEvent('data-updated',['message'=>"Membre mise à jour !"]);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode()=="22007") {
                session()->flash('error_msg',"Vérifier le format de la date SVP!");
            }
            if ($ex->getCode()=="23000") {
                session()->flash('error_msg',$ex->getMessage());
            }
        }
    }

    public function showDestroyFamillyDialog($id){
        $this->familly_to_delete_id=$id;
        $this->dispatchBrowserEvent('show-delete-member');
    }

    public function showDestroyMemberDialog($id){
        $this->member_to_delete_id=$id;
        $this->dispatchBrowserEvent('show-delete-member');
    }

    public function distroyFamilly(){
        $familly=Famille::find($this->familly_to_delete_id);
        $memebres=MembreFamille::where('famille_id',$familly->id)->get();
        if ($memebres !=null) {
            foreach ($memebres as $memebre) {
                $memebre->delete();
            }
        }
        if ($familly != null) {
            $familly->delete();
        }
        $this->dispatchBrowserEvent('data-deleted',['message'=>"Famille retirée du système"]);
    }

    public function distroyMember(){
        $member=MembreFamille::find($this->member_to_delete_id);
        if ($member != null) {
            $member->delete();
        }
        $this->dispatchBrowserEvent('date-deleted',['message'=>"Membre retirée du système"]);
    }

    public function mount(){
        $this->societes=SocieteForfait::all();
        $this->societe_to_add=SocieteForfait::all();
    }

    public function render()
    {
        return view('livewire.patients.forfait.patients-forfait-component',
        [
            'famillies'=>Famille::where('familles.name','Like','%'.$this->keySearch.'%')
            ->join('societe_forfaits','familles.societe_forfait_id','=','societe_forfaits.id')
            ->select('familles.*')
            ->where('societe_forfaits.name',$this->socity_name)
            ->orderBy('familles.created_at','DESC')
            ->paginate($this->page_number),


        ]);
    }
}
