<div wire:ignore.self id="newDayModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-bold text-primary" id="my-modal-title">
                    <span style="font-size: 20px;">AJOUTER UN JOUR</span>
                </h3>
                <button
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Jour:</label>
                    <input wire:keydown.enter='store'  class="form-control" type="text" wire:model.defer="day_anme">
                    @error('day_anme') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" wire:click='save' type="button">Valider</button>
            </div>
        </div>
    </div>
</div>
