<div wire:ignore.self id="addNewRecette" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Ajout d'une nouvelle recette</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                   <label >Montant</label>
                   <input class="form-control" type="text" wire:model.defer="mt_cdf">
                   @error('mt_cdf') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
               </div>
               <div class="form-group">
                    <label >Montant</label>
                    <input class="form-control" type="text" wire:model.defer="mt_usd">
                    @error('mt_usd') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" wire:click='store' type="button">Ajouter</button>
            </div>
        </div>
    </div>
</div>
