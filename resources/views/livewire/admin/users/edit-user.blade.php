<div wire:ignore.self id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">EDITION D'UN UTILISATEUR</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                   <label for="my-input">Nom de l'utilisateur</label>
                   <input class="form-control" type="text" wire:model.defer='name'autocomplete="name" >
                   @error('name') <span class="error text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>{{ $message }}</span> @enderror
               </div>
               <div class="form-group">
                <label for="my-input">Pseudo</label>
                <input class="form-control" type="text"  wire:model.defer='pseudo'autocomplete="pseudo">
                @error('pseudo') <span class="error text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="my-input">Email</label>
                <input class="form-control" type="text" wire:model.defer='email' autocomplete="email">
                @error('email') <span class="error text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="my-select">Role</label>
                <select id="my-select" class="form-control" wire:model.defer='role_id'>
                    <option>Choisir le role...</option>
                    @foreach ($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" wire:click='update'>Sauvegarder</button>
            </div>
        </div>
    </div>
</div>
