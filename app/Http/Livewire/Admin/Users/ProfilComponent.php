<?php

namespace App\Http\Livewire\Admin\Users;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilComponent extends Component
{
    use WithFileUploads;
    public $name,$pseudo,$password,$old_password,$password_confirm,$avatar;

    public function update(){
        if ($this->avatar==null) {
            $this->validate([
                'name'=>'required',
                'pseudo'=>'required',
            ]);
            try {
                $user=Auth::user();
                $user->name=$this->name;
                $user->pseudo=$this->pseudo;
                $user->update();
                $this->dispatchBrowserEvent('data-updated',['message'=>'Utilisateur '.$this->name.' bien mise à jour']);
            } catch(QueryException $ex){
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
            }
        }else{
            $this->validate([
                'name'=>'required',
                'pseudo'=>'required',
                'avatar' => 'image|max:1024', // 1MB Max
            ]);

            try {
                $avatar_name=time().'_'.$this->avatar->getClientOriginalName();
                $avatar_path = $this->avatar->storeAs('avatars', $avatar_name,'public');
                //dd($avatar_path);
                $user=Auth::user();
                $user->name=$this->name;
                $user->pseudo=$this->pseudo;
                $user->avatar=$avatar_path;
                $user->update();
                $this->dispatchBrowserEvent('data-updated',['message'=>'Utilisateur '.$this->name.' bien mise à jour']);
            } catch(QueryException $ex){
                $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
            }
        }

    }

    public function updatePassword(){
        $this->validate([
            'password'=>'required',
            'old_password'=>'required',
            'password_confirm'=>'required',
        ]);
        try {
            $user=Auth::user();

            if (Hash::check($this->password, $user->password )) {
               session()->flash('message','Ancien mot de passe incorrect !');
            }
            elseif($this->password != $this->password_confirm)
            {
                session()->flash('message','Confirmer votre mot de passe SVP!');
            }
            else{
                $user->password=Hash::make($this->password);
                $user->update();
                $this->dispatchBrowserEvent('data-updated',['message'=>'Utilisateur '.$this->name.' bien mise à jour']);
            }
        } catch(QueryException $ex){
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function mount(){
        $this->name=Auth::user()->name;
        $this->pseudo=Auth::user()->pseudo;
    }
    public function render()
    {
        return view('livewire.admin.users.profil-component');
    }
}
