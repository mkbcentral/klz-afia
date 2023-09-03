<div wire:ignore.self id="addPatientForfait" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">AJOUTER UNE NOUVELLE FAMILLE</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (session()->has('error_msg'))
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        {{ session('error_msg') }}
                    </div>
                @endif
                <div class="form-group">
                    <label >Nom de la famille</label>
                    <input wire:model.defer='name_familly' class="form-control" type="text">
                    @error('name_familly') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label >Numéro matricule</label>
                    <input wire:model.defer='matricule' class="form-control" type="text">
                    @error('matricule') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="my-select">Societé</label>
                    <select class="form-control" wire:model.defer='societe_id'>
                        <option class="">Choisir la société</option>
                        @foreach ($societe_to_add as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('societe_id') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button wire:click='store' class="btn btn-info" type="button"><i class="fa fa-check" aria-hidden="true"></i> Ajouter</button>
            </div>
        </div>
    </div>
</div>
