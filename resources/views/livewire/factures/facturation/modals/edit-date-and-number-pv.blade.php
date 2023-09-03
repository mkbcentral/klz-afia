<div wire:ignore.self id="editNumAndDateModalPv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Title</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="my-input">Numero facture</label>
                    <input  class="form-control" wire:keydown.enter='editNumAndDatePv' type="text" wire:model.defer="numToEdit">
                </div>
                <div class="form-group">
                    <label for="my-input">Date emise facture</label>
                    <input  class="form-control" type="datetime" wire:keydown.enter='editNumAndDatePv' wire:model.defer="dateToEdit">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" wire:click='editNumAndDatePv' type="button">Valider</button>
            </div>
        </div>
    </div>
</div>
