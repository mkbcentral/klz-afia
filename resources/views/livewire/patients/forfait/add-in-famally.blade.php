<div wire:ignore.self id="addInFamilyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">AJOUTER UN MEMBRE DANS LA FAMILLEE</h5>
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
                <div class="card">
                    <div class="card-body">
                        @if ($familly_to_add_member ==null)

                        @else
                        <h5 class="card-title">Nom famille: {{$familly_to_add_member->name}}</h5>
                        @endif

                    </div>
                </div>
                <div class="form-group">
                    <label >Nom comple</label>
                    <input wire:model.defer='member_familly_name' class="form-control" type="text">
                    @error('member_familly_name') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label >Date de naissance</label>
                    <input wire:model.defer='member_fmailly_date_naiss' class="form-control" type="date">
                    @error('member_fmailly_date_naiss') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="my-select">Type du membre</label>
                    <select class="form-control" wire:model.defer='member_familly_type'>
                        <option class="">Choisir le type</option>
                        <option class="">Agent</option>
                        <option class="">Epouse</option>
                        <option class="">Enfant</option>
                    </select>
                    @error('societe_id') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button wire:click='addInFamilly' class="btn btn-info" type="button"><i class="fa fa-check" aria-hidden="true"></i> Ajouter</button>
            </div>
        </div>
    </div>
</div>
