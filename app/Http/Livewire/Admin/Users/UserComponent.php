<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    public $page_cout=25;

    public $name,$email,$pseudo,$password_show,$password_result;
    public $roles,$role_id;
    public $user,$keySearch=null;

    public function updatingkeySearch()
    {
        $this->resetPage();
    }

    public function show($id){
        $this->user=User::find($id);

        //dd($this->user);
        $this->name=$this->user->name;
        $this->email=$this->user->email;
        $this->pseudo=$this->user->pseudo;
        $this->role_id=$this->user->role_id;
        $this->password_show=$this->user->password;
    }
    public function store(){
        $this->validate([
            'name'=>'required',
            'email'=>'required|email',
            'pseudo'=>'required',
            'role_id'=>'required'
        ]);
        try {
            $user=User::create([
                'name'=>$this->name,
                'pseudo'=>$this->pseudo,
                'email'=>$this->email,
                'password'=>Hash::make('123456'),
                'role_id'=>$this->role_id
            ]);
            $this->dispatchBrowserEvent('data-added',['message'=>'Utilisateur '.$user->name.' bien ajouté']);
        } catch(QueryException $ex){
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function update(){
        $this->validate([
            'name'=>'required',
            'email'=>'required|email',
            'pseudo'=>'required',
            'role_id'=>'required'
        ]);
        try {
            $this->user->name=$this->name;
            $this->user->email=$this->email;
            $this->user->pseudo=$this->pseudo;
            $this->user->role_id=$this->role_id;
            $this->user->update();
            $this->dispatchBrowserEvent('data-updated',['message'=>'Utilisateur '.$this->name.' bien mise à jour']);
        } catch(QueryException $ex){
            $this->dispatchBrowserEvent('data-add-faild',['message'=>$ex->getMessage()]);
        }
    }

    public function activeUuser($id){
        $user=User::find($id);
        $user->is_activate=true;
        $user->update();
        $this->dispatchBrowserEvent('data-deleted',['message'=>'Utilisateur '.$user->name.' bien desactivé']);
    }

    public function unActiveUuser($id){
        $user=User::find($id);
        $user->is_activate=false;
        $user->update();
        $this->dispatchBrowserEvent('data-deleted',['message'=>'Utilisateur '.$user->name.' bien desactivé']);
    }

    public function unCriptPassword(){
        $decrypt= Hash::make($this->user->password);
        dd($decrypt);
        $this->password_result=$decrypt;
    }

    public function upadatePassword(User $user){
        $user->password=bcrypt('password');
        $user->update();
        $this->dispatchBrowserEvent('data-updated',['message'=>'Mot de passe bien rénitialisé']);
    }

    public function mount(){
        $this->roles=Role::all();
        if (Auth::user()->isOnLine()) {
           dd('ok');
        }
    }
    public function render()
    {
        return view('livewire.admin.users.user-component',
            [
                'users'=>User::where('name','LIKE','%'.$this->keySearch.'%')->paginate($this->page_cout)
            ]
        );
    }
}
