<div wire:ignore.self id="addNewResultatModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">PUBLIER UN NOUVEAU RESULTAT</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nom du patient</label>
                    <input class="form-control" type="text" wire:model.defer="name">
                    @error('name')
                        <span class="error text-danger">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="my-select">Typê</label>
                    <select id="my-select" class="form-control"wire:model.defer='type'>
                        <option selected>Privé</option>
                        @foreach ($types as $type)
                            <option>{{$type->name}}</option>
                        @endforeach
                        <option>Personnels</option>
                    </select>
                    @error('type')
                        <span class="error text-danger">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group mt-2">
                    <label for="formFile" class="form-label">Fichier du resultat</label>
                    <input class="form-control" type="file" wire:model.defer='resultat_file'>
                  </div>
                  @error('resultat_file')
                    <span class="error text-danger">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" wire:click='store'>
                    <i class="fa fa-upload" aria-hidden="true"></i>
                     Publier
                </button>
            </div>
        </div>
    </div>
</div>
