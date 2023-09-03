<div wire:ignore.self id="addNewDepense" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">REALISATION DEPENSES</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        @if ($recette)
                            <span>DEPNSE SUR UNE ENTREE EN {{$recette->devise}}</span>
                        @endif
                    </div>
                </div>
               <div class="form-group">
                   <label >Montant</label>
                   <input class="form-control" type="text" wire:model.defer="mt_depense">
                   @error('mt_cdf') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
               </div>
               <div class="form-group">
                    <label >Montant</label>
                   <textarea wire:model.defer="libelle" class="form-control" id="" cols="5" rows="2"></textarea>
                    @error('mt_usd') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="my-select">Devise</label>
                    <select id="my-select" class="form-control select2" wire:model.defer='devise'>
                        <option>Choisir la devise</option>
                        <option>CDF</option>
                        <option>USD</option>
                    </select>
                    @error('devise') <span class="error text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" wire:click='storeDepense' type="button">Ajouter</button>
            </div>
        </div>
    </div>
</div>
