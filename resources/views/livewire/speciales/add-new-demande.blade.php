<div wire:ignore.self id="addDemandeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">AJOUTER UNE NOUVELLE DEMANDE</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="my-input">Nom du patient</label>
                    <input class="form-control" type="text" wire:model.defer="name">
                    @error('name')
                        <span class="error text-danger">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="my-select">Type</label>
                    <select id="my-select" class="form-control" wire:model.defer="type">
                        <option>Choisir...</option>
                        <option>Privé</option>
                        @foreach ($abonnements as $item)
                            <option value="{{$item->name}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('name')
                    <span class="error text-danger">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}
                    </span>
                @enderror
                </div>
                <div class="form-group">
                    <label for="my-input">Venu le</label>
                    <input wire:keydown.enter='store' class="form-control" type="date" wire:model.defer="date_venue">
                    @error('name')
                    <span class="error text-danger">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                        {{ $message }}
                    </span>
                @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='store' class="btn btn-danger" type="button">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>
