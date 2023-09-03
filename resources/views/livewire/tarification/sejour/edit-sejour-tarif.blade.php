<div wire:ignore.self id="editSejourTarif" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Edition examen labo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="my-input">Nom exame</label>
                            <input id="my-input" class="form-control" type="text" wire:model.defer='name'>
                            @error('name')
                                <span class="error text-danger">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="my-input">Prix privé</label>
                            <input id="my-input" class="form-control" type="text" wire:model.defer='price_prive'>
                            @error('price_prive')
                                <span class="error text-danger">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="my-input">Prix abonné</label>
                            <input id="my-input" class="form-control" type="text" wire:model.defer='price_abonne'>
                            @error('price_abonne')
                                <span class="error text-danger">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-secondary" type="button" wire:click='update'>Modidifer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
