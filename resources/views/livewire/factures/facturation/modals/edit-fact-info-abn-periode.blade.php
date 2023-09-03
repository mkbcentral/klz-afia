<div wire:ignore.self id="EditNumAndDateModalAbnPeriode" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">EDITION DU NUMERO ET DE LA DATE</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="my-input">Numero facture</label>
                    <input  class="form-control" type="text" wire:keydown.enter='editNumAndDate' wire:model.defer="numToEdit">
                </div>
                <div class="form-group">
                    <label for="my-input">Date emise facture</label>
                    <input  class="form-control" wire:keydown.enter='editNumAndDate' type="datetime" wire:model.defer="dateToEdit">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" wire:click='editNumAndDate' type="button">Valider</button>
            </div>
        </div>
    </div>
</div>
