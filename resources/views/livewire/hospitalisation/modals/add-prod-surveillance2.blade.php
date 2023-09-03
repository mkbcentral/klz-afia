<div wire:ignore.self id="addSurProductsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Ajouter une prescription</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="my-input">Quantité</label>
                    <input id="my-input" placeholder="0" class="form-control" type="text" wire:model.defer='qty'>
                </div>
                <div class="form-group">
                    <label for="my-input">Heure</label>
                    <input id="my-input" class="form-control" placeholder="00:00" type="text" wire:model.defer='time_data'>
                </div>
                <div>
                    <button wire:click='validedData()' class="btn btn-info" type="button">Ajouter</button>
                </div>
            </div>

        </div>
    </div>
</div>
