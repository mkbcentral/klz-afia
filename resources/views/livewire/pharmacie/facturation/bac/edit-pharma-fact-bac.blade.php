<div wire:ignore.self id="editFactureBacModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">EDTION FACTURE AMBULANT</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nom du patient</label>
                    <input wire:keydown.enter='update'  class="form-control" type="text" wire:model.defer="name">
                </div>
                @error('name') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror

                <div class="form-group">
                    <label>Date</label>
                    <input wire:keydown.enter='update'  class="form-control" type="text" wire:model.defer="dateFact">
                </div>
                @error('name') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>{{ $message }}</span> @enderror
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" wire:click='update' type="button">Valider</button>
            </div>
        </div>
    </div>
</div>
